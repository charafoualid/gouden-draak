<script setup>
import { computed, ref } from 'vue'

const props = defineProps({
    gerechtenPerCategorie: {
        type: Object,
        required: true,
    },
    modus: {
        type: String,
        default: 'kassa',
    },
    tafelnummer: {
        type: Number,
        default: null,
    },
})
const bestelling = ref([])

function voegGerechtToe(gerecht) {
    const bestaandGerecht = bestelling.value.find(
        item => item.id === gerecht.id
    )

    if (bestaandGerecht) {
        bestaandGerecht.aantal += 1
        return
    }

    bestelling.value.push({
        ...gerecht,
        aantal: 1,
    })
}

const totaalbedrag = computed(() => {
    return bestelling.value.reduce((totaal, gerecht) => {
        return totaal + Number(gerecht.price) * Number(gerecht.aantal || 0)
    }, 0)
})

function formatPrice(price) {
    return Number(price).toLocaleString('nl-NL', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    })
}

function verwijderBestelling() {
    bestelling.value = []
}

async function afrekenen() {
    if (bestelling.value.length === 0) {
        return
    }

    try {

        const endpoint = props.modus === 'tablet'
        ? '/bestellen/plaatsen'
        : '/kassa/afrekenen'

        const response = await fetch(endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute('content'),
            },
            body: JSON.stringify({
                gerechten: bestelling.value.map(gerecht => ({
                    id: gerecht.id,
                    aantal: gerecht.aantal,
                })),
            }),
        })

        const resultaat = await response.json()

        if (!response.ok) {
            throw new Error(resultaat.message ?? 'Afrekenen is mislukt.')
        }

        bestelling.value = []
        alert(resultaat.message)
    } catch (fout) {
        alert(fout.message)
    }
}
</script>

<template>
    <section class="cash-desk">
        <div class="cash-desk__left">
            <div class="cash-desk__menu">
                <template
                    v-for="(gerechten, soortgerecht) in gerechtenPerCategorie"
                    :key="soortgerecht"
                >
                    <h2 class="cash-desk__heading">
                        {{ soortgerecht }}
                    </h2>

                    <table class="cash-desk__menu-table">
                        <tbody>
                            <tr
                                v-for="gerecht in gerechten"
                                :key="gerecht.id"
                            >
                                <td>
                                    {{ gerecht.menunummer }}{{ gerecht.menu_toevoeging ?? '' }}.
                                </td>

                                <td>
                                    {{ gerecht.naam }}

                                    <i v-if="gerecht.beschrijving">
                                        ({{ gerecht.beschrijving }})
                                    </i>
                                </td>

                                <td>
                                    € {{ formatPrice(gerecht.price) }}
                                </td>

                                <td>
                                    <button type="button" @click="voegGerechtToe(gerecht)">
                                        Toevoegen
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </template>
            </div>
        </div>

        <div class="cash-desk__right">
            <div class="cash-desk__order-container">
                <div class="cash-desk__order">
                    <h2 class="cash-desk__heading cash-desk__order-heading">
                        Bestelling
                    </h2>

                    <table class="cash-desk__order-table">
                        <tbody>
                            <tr
                                v-for="gerecht in bestelling"
                                :key="gerecht.id"
                            >
                                <td>
                                    {{ gerecht.menunummer }}{{ gerecht.menu_toevoeging ?? '' }}.
                                </td>

                                <td>
                                    {{ gerecht.naam }}

                                    <i v-if="gerecht.beschrijving">
                                        ({{ gerecht.beschrijving }})
                                    </i>
                                </td>

                                <td>
                                    € {{ formatPrice(gerecht.price * gerecht.aantal) }}
                                </td>

                                <td>
                                    <input
                                        v-model.number="gerecht.aantal"
                                        type="number"
                                        min="1"
                                    >
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="cash-desk__total">
                    <table class="cash-desk__total-table">
                        <tbody>
                            <tr>
                                <td></td>
                                <td>Totaal:</td>
                                <td>€ {{ formatPrice(totaalbedrag) }}</td>

                                <td class="cash-desk__actions">
                                    <button
                                        id="payOrder"
                                        type="button"
                                        :disabled="bestelling.length === 0"
                                        @click="afrekenen"
                                    >
                                        {{ modus === 'tablet' ? 'Bestelling plaatsen' : 'Afrekenen' }}
                                    </button>
                                    <button type="button" @click="verwijderBestelling">Verwijderen</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</template>
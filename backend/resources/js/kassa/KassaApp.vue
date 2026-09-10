<script setup>
import { computed, ref } from 'vue'

defineProps({
    gerechtenPerCategorie: {
        type: Object,
        required: true,
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
                                    <button type="button">Afrekenen</button>
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
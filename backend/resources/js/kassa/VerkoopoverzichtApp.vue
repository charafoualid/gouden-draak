<script setup>
import { ref } from 'vue'

function vandaag() {
    const datum = new Date()
    const jaar = datum.getFullYear()
    const maand = String(datum.getMonth() + 1).padStart(2, '0')
    const dag = String(datum.getDate()).padStart(2, '0')

    return `${jaar}-${maand}-${dag}`
}

const begindatum = ref(vandaag())
const einddatum = ref(vandaag())
const verkoopregels = ref([])

const totalen = ref({
    inclusief_btw: 0,
    btw: 0,
    exclusief_btw: 0,
})

const foutmelding = ref('')
const laden = ref(false)

function formatPrice(bedrag) {
    return Number(bedrag).toLocaleString('nl-NL', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    })
}

function formatDate(datum) {
    return new Date(datum).toLocaleDateString('nl-NL')
}

async function maakOverzicht() {
    foutmelding.value = ''
    laden.value = true

    const parameters = new URLSearchParams({
        begindatum: begindatum.value,
        einddatum: einddatum.value,
    })

    try {
        const response = await fetch(
            `/kassa/verkoopoverzicht/gegevens?${parameters}`,
            {
                headers: {
                    Accept: 'application/json',
                },
            }
        )

        const resultaat = await response.json()

        if (!response.ok) {
            throw new Error(
                resultaat.message ?? 'Ophalen van verkopen is mislukt.'
            )
        }

        verkoopregels.value = resultaat.verkoopregels
        totalen.value = resultaat.totalen
    } catch (fout) {
        foutmelding.value = fout.message
    } finally {
        laden.value = false
    }
}
</script>

<template>
    <section class="sales-overview">
        <div class="sales-overview__top">
            <div class="sales-overview__filters">
                <label>
                    Begin datum:
                    <input v-model="begindatum" type="date">
                </label>

                <label>
                    Eind datum:
                    <input v-model="einddatum" type="date">
                </label>

                <button
                    type="button"
                    :disabled="laden"
                    @click="maakOverzicht"
                >
                    {{ laden ? 'Laden...' : 'Maak Overzicht' }}
                </button>
            </div>

            <div class="sales-overview__totals">
                <strong>
                    Omzet: € {{ formatPrice(totalen.inclusief_btw) }}
                </strong>

                <strong>
                    BTW: € {{ formatPrice(totalen.btw) }}
                </strong>

                <strong>
                    excl. BTW: € {{ formatPrice(totalen.exclusief_btw) }}
                </strong>
            </div>
        </div>

        <p v-if="foutmelding">
            {{ foutmelding }}
        </p>

        <div class="sales-overview__results">
            <table>
                <thead>
                    <tr>
                        <th>Datum</th>
                        <th>Gerecht</th>
                        <th>Prijs</th>
                        <th>Aantal</th>
                        <th>Subtotaal</th>
                    </tr>
                </thead>

                <tbody>
                    <tr
                        v-for="regel in verkoopregels"
                        :key="`${regel.bestelling_id}-${regel.menu_id}`"
                    >
                        <td>{{ formatDate(regel.besteldatum) }}</td>
                        <td>{{ regel.naam }}</td>
                        <td>€ {{ formatPrice(regel.prijs) }}</td>
                        <td>{{ regel.aantal }}</td>
                        <td>€ {{ formatPrice(regel.subtotaal) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</template>
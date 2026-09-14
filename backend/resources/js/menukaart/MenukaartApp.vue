<script setup>
import { computed, ref } from 'vue'

const props = defineProps({
    gerechtenPerCategorie: {
        type: Object,
        required: true,
    },
})

const sortering = ref('standaard')

const getoondeGerechten = computed(() => {
    const categorieen = Object.entries(props.gerechtenPerCategorie)

    if (sortering.value === 'favorieten-bovenaan') {
        return Object.fromEntries(
            categorieen.map(([categorie, gerechten]) => [
                categorie,
                [...gerechten].sort((a, b) => {
                    return Number(isFavoriet(b.id)) -
                        Number(isFavoriet(a.id))
                }),
            ])
        )
    }

    if (sortering.value === 'alleen-favorieten') {
        const favorietenLijst = categorieen
            .flatMap(([, gerechten]) => gerechten)
            .filter(gerecht => isFavoriet(gerecht.id))
            .sort((a, b) => a.naam.localeCompare(b.naam, 'nl'))

        return favorietenLijst.length
            ? { Favorieten: favorietenLijst }
            : {}
    }

    return props.gerechtenPerCategorie
})

function leesFavorieten() {
    const cookie = document.cookie
        .split('; ')
        .find(cookie => cookie.startsWith('favorieten='))

    if (!cookie) {
        return []
    }

    try {
        return JSON.parse(
            decodeURIComponent(cookie.split('=')[1])
        )
    } catch {
        return []
    }
}

const favorieten = ref(leesFavorieten())

function isFavoriet(id) {
    return favorieten.value.includes(id)
}

function bewaarFavorieten() {
    document.cookie = `favorieten=${encodeURIComponent(
        JSON.stringify(favorieten.value)
    )}; max-age=31536000; path=/; SameSite=Lax`
}

function wisselFavoriet(id) {
    if (isFavoriet(id)) {
        favorieten.value = favorieten.value.filter(
            favorietId => favorietId !== id
        )
    } else {
        favorieten.value.push(id)
    }

    bewaarFavorieten()
}

function formatPrijs(prijs) {
    return Number(prijs).toFixed(2).replace('.', ',')
}
</script>

<template>
    <section class="menu-list">
        <div class="menu-list__toolbar">
            <h2>Menukaart</h2>
            
            <label>
                Sorteren:
                <select v-model="sortering">
                    <option value="standaard">Standaard</option>
                    <option value="favorieten-bovenaan">
                        Favorieten bovenaan
                    </option>
                    <option value="alleen-favorieten">
                        Alleen favorieten
                    </option>
                </select>
            </label>

            <button type="button">
                Menu downloaden als PDF
            </button>
        </div>

        <section
            v-for="(gerechten, categorie) in getoondeGerechten"
            :key="categorie"
            class="menu-list__category"
        >
            <h3>{{ categorie }}</h3>

            <div
                v-for="gerecht in gerechten"
                :key="gerecht.id"
                class="menu-list__item"
            >
                <button
                    type="button"
                    class="menu-list__favorite"
                    :aria-label="isFavoriet(gerecht.id)
                        ? 'Verwijderen uit favorieten'
                        : 'Toevoegen aan favorieten'"
                    @click="wisselFavoriet(gerecht.id)"
                >
                    {{ isFavoriet(gerecht.id) ? '★' : '☆' }}
                </button>

                <span class="menu-list__number">
                    {{ gerecht.menunummer }}{{ gerecht.menu_toevoeging ?? '' }}.
                </span>

                <span class="menu-list__name">
                    {{ gerecht.naam }}

                    <i v-if="gerecht.beschrijving">
                        ({{ gerecht.beschrijving }})
                    </i>
                </span>

                <span class="menu-list__price">
                    € {{ formatPrijs(gerecht.price) }}
                </span>
            </div>
        </section>
    </section>
</template>
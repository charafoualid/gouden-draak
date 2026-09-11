import { createApp } from 'vue'
import KassaApp from './kassa/KassaApp.vue'
import VerkoopoverzichtApp from './kassa/VerkoopoverzichtApp.vue'

const kassaElement = document.querySelector('#kassa-app')

if (kassaElement) {
    const gerechtenPerCategorie = JSON.parse(
        kassaElement.dataset.gerechten
    )

    createApp(KassaApp, {
        gerechtenPerCategorie,
    }).mount(kassaElement)
}

const verkoopoverzichtElement = document.querySelector(
    '#verkoopoverzicht-app'
)

if (verkoopoverzichtElement) {
    createApp(VerkoopoverzichtApp).mount(verkoopoverzichtElement)
}

const tabletBestellingElement = document.querySelector(
    '#tablet-bestelling-app'
)

if (tabletBestellingElement) {
    const gerechtenPerCategorie = JSON.parse(
        tabletBestellingElement.dataset.gerechten
    )

    createApp(KassaApp, {
        gerechtenPerCategorie,
        modus: 'tablet',
        tafelnummer: Number(
            tabletBestellingElement.dataset.tafelnummer
        ),
    }).mount(tabletBestellingElement)
}
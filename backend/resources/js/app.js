import { createApp } from 'vue'
import KassaApp from './kassa/KassaApp.vue'
import VerkoopoverzichtApp from './kassa/VerkoopoverzichtApp.vue'
import MenukaartApp from './menukaart/MenukaartApp.vue'

const kassaElement = document.querySelector('#kassa-app')

if (kassaElement) {
    const gerechtenPerCategorie = JSON.parse(
        kassaElement.dataset.gerechten
    )

    const veelgebruikteOpmerkingen = JSON.parse(
    kassaElement.dataset.opmerkingen
    )

    createApp(KassaApp, {
        gerechtenPerCategorie,
        veelgebruikteOpmerkingen,
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

const menukaartElement = document.querySelector('#menukaart-app')

if (menukaartElement) {
    const gerechtenPerCategorie = JSON.parse(
        menukaartElement.dataset.gerechten
    )

    createApp(MenukaartApp, {
        gerechtenPerCategorie,
    }).mount(menukaartElement)
}
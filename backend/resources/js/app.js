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
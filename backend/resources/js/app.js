import { createApp } from 'vue'
import KassaApp from './kassa/KassaApp.vue'

const kassaElement = document.querySelector('#kassa-app')

if (kassaElement) {
    const gerechtenPerCategorie = JSON.parse(
        kassaElement.dataset.gerechten
    )

    createApp(KassaApp, {
        gerechtenPerCategorie,
    }).mount(kassaElement)
}
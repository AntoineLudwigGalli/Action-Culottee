import {Partner} from "./partner.js";

export class Overlay
    extends Partner {

    /**
     * Méthode de création d'un overlay
     */
    createOverlay(locationImage) {

        // Div avec la class overlay
        document.querySelector('body')
            .prepend(document.createElement('div'));
        document.querySelector('body>div')
            .setAttribute('class',
                'overlay-partner');

        gsap.to('.overlay-partner',
            .3,
            {
                opacity: "1",
                ease: Power3.easeInOut
            });

        this.createPartnerPopup(locationImage);

    }

    /**
     * Méthode asynchrone de suppréssion d'un overlay
     */
    async deleteOverlay() {

        // Création d'une promesse "sleep" pour attendre l'action quel sois fini afin de suprrimé l'overlay
        const sleep = ms => new Promise(r => setTimeout(r,
            ms));

        // Animation fondu sur l'overlay avec l'utilisation de la librairie gsap
        gsap.to('.overlay-partner',
            .2,
            {
                opacity: "0",
                ease: Power3.easeInOut
            });

        // Attente de 500 miliseconds
        await sleep(500);

        // On supprime l'overlay
        document.querySelector('.overlay-partner')
            .remove();

    }

}










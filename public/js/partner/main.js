import { Overlay } from "./overlay.js";
import {Partner} from "./partner.js";

const overlay = new Overlay();
const partnerOverlay = new Partner();

const getId = [partnerOverlay.getElement()];

console.log(getId[0]);


// Séléctionne toute les cardes
document.querySelectorAll('.card a img').forEach(function (element) {

    // Ajout d'un évènement "click" sur chaque card
    element.addEventListener('click',  function (e) {

        // Applique l'overlay
        overlay.createOverlay( this.getAttribute('src') );

        // Application du text dynamic sur l'overlay
        const elementTitle = partnersL[this.dataset.ov1]['title'];
        const elementDescription = partnersL[this.dataset.ov1]['description'];
        const elementLogo = partnersL[this.dataset.ov1]['logo'];

        const selectOverlay = document.querySelector('.overlay-partner');

        selectOverlay.querySelector('h1').textContent = elementTitle;
        selectOverlay.querySelector('.img-p-partner p').textContent = elementDescription;


        // Ajout d'un évènement "click" sur l'overlay
        document.querySelector('.overlay-partner').addEventListener('click', function (e) {

            // Séléctionne l'ID du block "partner-info"
            const partner = document.getElementById('partner-info');

            // Si le click est en dehors de "partner-info" on supprime l'overlay
            if ( document.body.contains(partner) && !partner.contains(e.target) ) {
                overlay.deleteOverlay();
            }

        });

        // Ajout d'un évènement "click" sur X
        document.querySelector('.fa-xmark ').addEventListener('click', function (e) {
            overlay.deleteOverlay();
        });


    });

});
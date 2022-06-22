import { Overlay } from "./overlay.js";
import {Partner} from "./partner.js";

const overlay = new Overlay();

// Séléctionne toute les cardes
document.querySelectorAll('.card a img').forEach(function (element) {

    // Ajout d'un évènement "click" sur chaque card
    element.addEventListener('click',  function (e) {

        // Applique l'overlay
        overlay.createOverlay( this.getAttribute('src') );

        // Application du text dynamic sur l'overlay
        const elementTitle = partnersL[this.dataset.ov1]['title'];
        const elementDescription = partnersL[this.dataset.ov1]['description'];
        const elementOffer = partnersL[this.dataset.ov1]['offer'];

        const selectOverlay = document.querySelector('.overlay-partner');

        selectOverlay.querySelector('h1').textContent = elementTitle;
        selectOverlay.querySelector('.img-p-partner p').textContent = elementDescription;


        if ( checkIfUser ) {


            const button =  document.querySelector('#partner-info div button');

            button.addEventListener('click', function () {

                const text = 'Offre';

                if ( button.textContent.toLowerCase().includes( text.toLowerCase() ) ) {

                    this.textContent = 'Retour';

                    this.setAttribute('class', 'btn btn-danger w-25');

                    selectOverlay.querySelector('.img-p-partner p').textContent = elementOffer;

                } else {


                    this.textContent = 'Offre';

                    this.setAttribute('class', 'btn btn-warning w-25');

                    selectOverlay.querySelector('.img-p-partner p').textContent = elementDescription;


                }

            });


        }



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
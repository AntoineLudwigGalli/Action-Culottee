import { Overlay } from "./overlay.js";

const overlay = new Overlay();

// Séléctionne toute les cardes
document.querySelectorAll('.card a img').forEach(function (element) {

    // Ajout d'un évènement "click" sur chaque card
    element.addEventListener('click',  function (e) {

        // Applique l'overlay
        overlay.createOverlay( this.getAttribute('src') );

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
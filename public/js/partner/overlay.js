/*
*
* Fonction pour afficher l'overlay
*
*/
function openOverlayPartner() {

    gsap.to('.overlay',
        .5,
        {
            opacity: "1",
            ease: Power3.easeInOut
    });


    document.querySelector('.overlay').classList.toggle('d-none');

}

/*
*
* Fonction asynchrone pour fermer l'overlay
*
*/

async function closeOverlayPartner() {

    // Création d'une promesse "sleep" pour attendre que l'action soit terminée afin de supprimer l'overlay
    const sleep = ms => new Promise(r => setTimeout(r,
        ms));

    // Animation de fondu sur l'overlay avec l'utilisation de la librairie gsap
    gsap.to('.overlay',
        .2,
        {
            opacity: "0",
            ease: Power3.easeInOut
        });

    // Attente de 500 millisecondes
    await sleep(500);


    // Si il existe on le supprime
    if ( document.querySelector('.div-offer') ) {
        document.querySelector('.div-offer').parentElement.removeChild( document.querySelector('.div-offer') );
    }

    document.querySelector('.partner').classList.add('d-none');


}


/**
 *
 * Evenement click sur les images
 *
 */
document.querySelectorAll('.card img').forEach(function (element) {

    // Ajout d'un évènement "click" sur chaque card
    element.addEventListener('click',  function (e) {

        openOverlayPartner();

        // Application du texte dynamique sur l'overlay
        const partnerMark = partnersL[this.dataset.ov1]['title'];
        const partnerLogo = '/images/images-partners/' + partnersL[this.dataset.ov1]['logo'];
        const partnerDescription = partnersL[this.dataset.ov1]['description'];
        const partnerOffer = partnersL[this.dataset.ov1]['offer'];

        document.querySelector('.partner-title h2').textContent = partnerMark;
        document.querySelector('.partner-image img').setAttribute('src', partnerLogo);
        document.querySelector('.partner-sentence p').innerHTML = partnerDescription;

        if ( document.querySelector('.offer') ) {

        } else {

            if ( checkIfUser ) {

                // Creation du block pour l'offre
                const divButtonOffer = document.createElement('div');
                const linkOffer = document.createElement('a');
                const buttonOffer = document.createElement('button');

                // Ajout du bouton offre
                document.querySelector('.content').append( divButtonOffer );
                divButtonOffer.prepend( linkOffer );
                linkOffer.prepend( buttonOffer );


                // Ajout des classes sur l'offre
                divButtonOffer.setAttribute('class', 'text-center mt-5 div-offer');
                linkOffer.setAttribute('class', 'text-black text-decoration-underline');
                buttonOffer.setAttribute('class', 'btn button-orange offer w-25 mb-5');

                buttonOffer.textContent = 'Offre';

                // Ajout d'un évènement "click" uniquement quand l'overlay est affiché
                document.querySelector('.offer').addEventListener('click', function () {

                    const text = 'Offre';

                    if (this.textContent.toLowerCase().includes(text.toLowerCase())) {

                        this.textContent = 'Retour';

                        this.setAttribute('class', 'btn btn-back w-25 offer mb-5');

                        document.querySelector('.partner-sentence p').innerHTML = partnerOffer;

                    } else {

                        this.textContent = 'Offre';

                        this.setAttribute('class', 'btn button-orange w-25 offer mb-5');

                        document.querySelector('.partner-sentence p').innerHTML = partnerDescription;

                    }

                });

            }

        }

    });

});


// Évènement de click asynchrone pour attendre une execution afin d'en exécuter une autre
document.querySelector('.overlay').addEventListener('click', async function (ev) {

    const selectPartnerToDisplay = document.querySelector('.display-partner');

    // Si le body contient "display-partner" et quand il ne click pas dedans on ajoute la classe "d-none"
    if ( document.body.contains(selectPartnerToDisplay) && !selectPartnerToDisplay.contains(ev.target) ) {

        // Création d'une promesse "sleep" pour attendre que l'action soit terminée afin de supprimer l'overlay
        const sleep = ms => new Promise(r => setTimeout(r,
            ms));

        // Animation de fondu sur l'overlay avec l'utilisation de la librairie gsap
        gsap.to('.overlay',
            .2,
            {
                opacity: "0",
                ease: Power3.easeInOut
            });

        // Attente de 500 millisecondes
        await sleep(500);

        if ( document.querySelector('.div-offer') ) {
            document.querySelector('.div-offer').parentElement.removeChild( document.querySelector('.div-offer') );
        }

        await closeOverlayPartner();

    }
});
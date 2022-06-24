export class Partner {

    createPartnerPopup(imageLocation = null, getId) {

        // Div pour le positionnement du partenaire à affiché
        document.querySelector('.overlay-partner').prepend(document.createElement('div'));
        document.querySelector('.overlay-partner>div').setAttribute('class', 'row d-block col-12 col-md-8 mx-auto my-5 bg-white h-25');
        document.querySelector('.overlay-partner>div').setAttribute('id', 'partner-info');

        // Div pour le positionnement du titre et lien
        document.querySelector('.overlay-partner>div').prepend(document.createElement('div'));
        document.querySelector('.overlay-partner>div').setAttribute('class', 'container d-block col-12 col-md-8 mx-auto my-5 bg-black h-25');
        document.querySelector('.overlay-partner>div').setAttribute('id', 'partner-info');

        // Création du titre du partenaire
        document.querySelector('.overlay-partner>div').prepend(  document.createElement('h1') );
        document.querySelector('.overlay-partner>div h1').textContent = 'Blablabla';
        document.querySelector('.overlay-partner>div h1').setAttribute('class', 'text-center')

        // Création du lien du partenaire
        document.querySelector('.overlay-partner>div').prepend(  document.createElement('a') );
        document.querySelector('.overlay-partner>div a:first-child').textContent = 'Blablabla';
        document.querySelector('.overlay-partner>div h1').setAttribute('class', 'text-center')


        // Création de croix pour fermer l'overlay
        document.querySelector('.overlay-partner>div').prepend(  document.createElement('div') );
        document.querySelector('.overlay-partner>div>div').innerHTML = '<i class="fa-solid fa-xmark"></i>';
        document.querySelector('.overlay-partner>div>div').setAttribute('class', 'd-flex flex-row justify-content-end')


        // Création d'une div pour encapsuler l'image et le paragraphe
        document.querySelector('.overlay-partner>div').append(  document.createElement('div') );
        document.querySelector('.overlay-partner>div').lastElementChild.setAttribute('class', 'img-p-partner')
        document.querySelector('.overlay-partner .img-p-partner').setAttribute('class', 'd-flex flex-row mt-5 img-p-partner')


        // Création de l'image du partenaire
        document.querySelector('.overlay-partner .img-p-partner').prepend(  document.createElement('div') );
        document.querySelector('.overlay-partner .img-p-partner div').setAttribute('class',  'col-5');
        document.querySelector('.overlay-partner .img-p-partner div').prepend(  document.createElement('img') );
        document.querySelector('.overlay-partner .img-p-partner div img').setAttribute('alt',  '');
        document.querySelector('.overlay-partner .img-p-partner div img').setAttribute('src', imageLocation);
        document.querySelector('.overlay-partner .img-p-partner div img').setAttribute('class', 'w-100');


        // Description du partenaire
        document.querySelector('.overlay-partner .img-p-partner').append(  document.createElement('div') );
        document.querySelector('.overlay-partner .img-p-partner div:last-child').append(  document.createElement('p') );
        document.querySelector('.overlay-partner .img-p-partner div:last-child').setAttribute('class', 'ms-3 text-break w-100');

    }

    getElement() {

        const getId = [];

        document.querySelectorAll('.card a img').forEach(function (element) {

            // Ajout d'un évènement "click" sur chaque card
            element.addEventListener('click',  function (e) {

                getId[0] = this.dataset.ov1;
                getId[1] = this.dataset.ov2;

            });

        });

    }


}

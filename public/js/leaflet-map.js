// On définit les coordonnées affichées et le zoom initial au chargement de la page
let map = L.map('map').setView([46.657, 2.329], 6);

// todo : Bien penser à créditer la carte https://www.openstreetmap.org/copyright

// On choisit l'url de la tile (design de la map) voulue ainsi que le niveau de zoom max et le copyright
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="https://osm.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

$.getJSON("/ajax", function(data){

    for (let i=0; i < data.length; i++  ) {
        //Positionnement d'un marqueur //todo: pimper les marqueurs avec les icones de culottes
        let marker = L.marker([data[i].latitude, data[i].longitude]).addTo(map);
// On intègre une étiquette avec la description du marqueur (si on veut que ça apparaisse dès le chargement, il faut
// rajouter .openPopup() àla suite de cette ligne
        marker.bindPopup(
            "<b>" + data[i].name +"</b><br>" + data[i].address + "<br>" + data[i].zipcode +"<br>" + data[i].city+"<br>" + data[i].country+"<br>"
        //    todo: ajouter le téléphone
        );
    }

});

L.control.locate().addTo(map); // Ajout du leaflet Locate control pour la geolocalisation
// Ajout de la search bar du leaflet-control-geocoder et du zoom sur la zone recherchée
let geocoder = L.Control.geocoder({
    defaultMarkGeocode: false
})
    .on('markgeocode', function(e) {
        let bbox = e.geocode.bbox;
        let poly = L.polygon([
            bbox.getSouthEast(),
            bbox.getNorthEast(),
            bbox.getNorthWest(),
            bbox.getSouthWest()
        ]);
        map.fitBounds(poly.getBounds());
    })
    .addTo(map);




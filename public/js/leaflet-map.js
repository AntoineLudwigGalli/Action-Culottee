// On définit les coordonnées affichées et le zoom initial au chargement de la page
let map = L.map('map').setView([46.657, 2.329], 6);

// todo : Bien penser à créditer la carte https://www.openstreetmap.org/copyright

// On choisit l'url de la tile (design de la map) voulue ainsi que le niveau de zoom max et le copyright
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="https://osm.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);


//Positionnement d'un marqueur
let marker = L.marker([47.539813269690576, 4.4612659153420395]).addTo(map);
// On intègre une étiquette avec la description du marqueur (si on veut que ça apparaisse dès le chargmeent, il faut
// rajouter .openPopup() àla suite de cette ligne
marker.bindPopup(
    "<b>Jolie Chose</b><br>" +
    "26 avenue de Dijon<br>" +
    "Venarey-les-Laumes<br>" +
    "0380892703"
);
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




// On définit les coordonnées affichées et le zoom initial au chargement de la page
let map = L.map('map').setView([46.657, 2.329], 6);

// On choisit l'url de la tile (design de la map) voulue ainsi que le niveau de zoom max et le copyright
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="https://osm.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

// Personnalisation des icônes
let pantyIcon = L.icon({
    iconUrl: '../images/map_icon.png',
    iconSize:     [20, 20], // size of the icon
    iconAnchor:   [8, 20], // point of the icon which will correspond to marker's location
    popupAnchor:  [0, -20] // point from which the popup should open relative to the iconAnchor
});

$.getJSON("/ajax/shops", function(data){

    for (let i=0; i < data.length; i++  ) {
        //Positionnement d'un marqueur
        let marker = L.marker([data[i].latitude, data[i].longitude], {icon: pantyIcon}).addTo(map);
// On intègre une étiquette avec la description du marqueur (si on veut que ça apparaisse dès le chargement, il faut
// rajouter .openPopup() àla suite de cette ligne
        marker.bindPopup(
            "<span><b>" + data[i].name +"</b></span><br>" +
            "<span>" + data[i].phoneNumber +"</span><br>" +
            "<span style='text-transform: capitalize'>" + data[i].address + "</span><br>" +
            "<span>" + data[i].zipcode +"</span><br>" +
            "<span style='text-transform: uppercase'>" + data[i].city+"</span><br>" +
            "<span>" + data[i].country+"</span>"
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




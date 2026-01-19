<!DOCTYPE html>
<html>
<head>
    <title>Mapa conectado a MySQL</title>
    <meta charset="utf-8">

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
     
    <style>
        #map { height: 600px; width: 100%; }
    </style>
</head>

<body>

<h1>Mapa Interactivo</h1>
<div id="map"></div>

<script>
// ------------------------------------------
// 1. MAPA INICIAL
// ------------------------------------------
 var map = L.map('map').setView([8.4877054, -80.3146548], 8) // Coordenadas de Panamá, por ejemplo
 d
// ------------------------------------------
// 2. CAPA MAPA BASE
// ------------------------------------------
var capaMapa = L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    maxZoom: 18
}).addTo(map);

// ------------------------------------------
// 3. CAPA SATÉLITE
// ------------------------------------------
var capaSatelite = L.tileLayer(
    "https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}",
    { maxZoom: 18 }
);

//Híbrida (satélite con nombres encima)
var hibrido = L.tileLayer(
  'https://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}',
  { subdomains: ['mt0','mt1','mt2','mt3'] }
);

//Capa Topografía
var topografico = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png');


// ------------------------------------------
// 4. COLORES POR PROVINCIA
// ------------------------------------------
function provinciaPorID(id) {
    const mapa = {
        1: "Bocas del Toro",
        2: "Coclé",
        3: "Colón",
        4: "Chiriquí",
        5: "Darién",
        6: "Herrera",
        7: "Los Santos",
        8: "Panamá",
        9: "Veraguas",
        10: "Panamá Oeste",
        11: "Comarca Guna Yala",
        13: "Comarca Ngäbe-Buglé",
        14: "Comarca Emberá-Wounaan"
        
    };
    return mapa[id] || "Desconocido";
}
var colores = {
    "bocas del toro": "#ff0000",
    "cocle": "#00aa00",
    "colon": "#ff0066",
    "chiriqui": "#0000ff",
    "darien": "#996600",
    "herrera": "#00cccc",
    "los santos": "#cc00cc",
    "panama": "#0099ff",
    "panama oeste": "#800080",
    "veraguas": "#ff8800",
    "comarca ngabe-bugle": "#ca0404ff",
    "comarca guna yala": "#ff006fff",
    "comarca embera-wounaan": "#f1b7ffff"
};

function normalizar(nombre) {
    return nombre
        .normalize("NFD")
        .replace(/[\u0300-\u036f]/g, "")
        .toLowerCase()
        .trim();
}

// CAPA CONTENEDORA
var capaProvincias = L.layerGroup();

// ------------------------------------------
// 5. OBTENER LOS DATOS DESDE PHP/MySQL
// ------------------------------------------
fetch("datos_mapa.php")
    .then(res => res.json())
    .then(data => {

        data.forEach(item => {

            // Convertir ID → Nombre
            let provinciaNombre = provinciaPorID(item.provincia);

            // Normalizar para buscar color
            let key = normalizar(provinciaNombre);

            // Obtener color final
            let color = colores[key] || "black";

            // Crear marcador coloreado
            L.circleMarker([item.latitudG,item.longG], {
                radius: 6,
                color: color,
                fillColor: color,
                fillOpacity: 0.8
            })
            .bindPopup(
                "<b>Provincia:</b> " + provinciaNombre +
                "<br><b>Distrito:</b> " + item.distritos+
                "<br><b>Latitud:</b> " + item.latitudG +
                "<br><b>Longitud:</b> " + item.longG +
                "<br><b>Proyecto:</b> " + item.nombreProyecto             
            )
            .addTo(capaProvincias);

        });

    })
    .catch(err => console.error("Error:", err));

// ------------------------------------------
// 6. CONTROL DE CAPAS
// ------------------------------------------
var baseMaps = {
    "Mapa": capaMapa,
    "Satélite": capaSatelite,
    "Híbrida":hibrido,
    "Topografíco": topografico
};

var overlayMaps = {
    "Proyectos por Provincias": capaProvincias
};


L.control.layers(baseMaps, overlayMaps).addTo(map);

</script>

</body>
</html>

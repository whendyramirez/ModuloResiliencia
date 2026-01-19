<!DOCTYPE html>
<html>
<head>
  <title>Mapa Interactivo</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Cargar Leaflet desde CDN -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <style>
    #map {
      height: 700px;
      width: 100%;
      border-radius: 10px;
      box-shadow: 0 0 5px rgba(0,0,0,0.3);
    }

  </style>
</head>
<body>

<h3>Mapa Interactivo con Resultados</h3>
<div id="map"></div>

<script>
  // Crear el mapa y establecer vista inicial
  var map = L.map('map').setView([8.9824, -79.5199], 7.5) // Coordenadas de Panamá, por ejemplo

  // Agregar capa base (OpenStreetMap)
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
  }).addTo(map);

  // Ejemplo: marcador con resultado
  var marker = L.marker([8.9824, -79.5199]).addTo(map);
  marker.bindPopup("<b>Ciudad de Panamá</b>").openPopup();
   var marker = L.marker([8.745951579849033, -82.00379184612811]).addTo(map);
  marker.bindPopup("<b>Ciudad de Chiriquí</b>").openPopup();

  // Puedes agregar más marcadores o polígonos dinámicamente
</script>

</body>
</html>

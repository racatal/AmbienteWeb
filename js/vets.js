
document.addEventListener('DOMContentLoaded', () => {
  if (!navigator.geolocation || typeof L === 'undefined') {
    return alert('No se puede cargar el mapa o la geolocalización.');
  }

  const radiusInput  = document.getElementById('radius');
  const radiusValue  = document.getElementById('radius-value');
  const btnSearch    = document.getElementById('btn-search');

  // Inicializa el mapa
  const map = L.map('map').setView([9.934739, -84.087502], 13);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
  }).addTo(map);

  // Grupo para marcadores de veterinarias
  const resultsLayer = L.layerGroup().addTo(map);
  let userMarker;

  // Actualiza la etiqueta del slider
  radiusInput.addEventListener('input', () => {
    radiusValue.textContent = radiusInput.value;
  });


  function searchVets(lat, lon, km) {
    resultsLayer.clearLayers();
    const m = km * 1000;
    const query = `
      [out:json][timeout:25];
      (
        node["amenity"="veterinary"](around:${m},${lat},${lon});
        way["amenity"="veterinary"](around:${m},${lat},${lon});
      );
      out center;`;

    fetch('https://overpass-api.de/api/interpreter', {
      method: 'POST',
      body: query
    })
      .then(res => res.json())
      .then(data => {
        if (!data.elements || !data.elements.length) {
          return alert(`No se encontraron veterinarias en ${km} km.`);
        }
        data.elements.forEach(el => {
          const coords = el.type === 'node'
            ? [el.lat, el.lon]
            : [el.center.lat, el.center.lon];
          const name = el.tags.name || 'Veterinaria';
          L.marker(coords)
            .addTo(resultsLayer)
            .bindPopup(`<strong>${name}</strong><br>${el.tags['addr:street'] || ''}`);
        });
      })
      .catch(err => {
        console.error(err);
        alert('Error al buscar veterinarias.');
      });
  }


  navigator.geolocation.getCurrentPosition(
    pos => {
      const lat = pos.coords.latitude;
      const lon = pos.coords.longitude;
      map.setView([lat, lon], 14);


      userMarker = L.circleMarker([lat, lon], {
        radius: 8,
        color: '#007BFF',
        fillColor: '#007BFF',
        fillOpacity: 0.9
      })
        .addTo(map)
        .bindPopup('Tú estás aquí')
        .openPopup();

      // Búsqueda con radio por defecto
      searchVets(lat, lon, Number(radiusInput.value));

      // Al hacer click en “Buscar veterinarias”
      btnSearch.addEventListener('click', () => {
        searchVets(lat, lon, Number(radiusInput.value));
      });
    },
    err => {
      console.error(err);
      alert('Activa la geolocalización y recarga la página.');
    },
    { timeout: 10000 }
  );
});

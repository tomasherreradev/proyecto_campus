if(document.querySelector('#mapa')) {
    const latitud = -29.411806273092687;
    const longitud = -66.85880730133084;
    const zoom = 16;

    const map = L.map('mapa').setView([latitud, longitud], zoom);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    L.marker([latitud, longitud, -0.09]).addTo(map)
        .bindPopup(`
            <h2 class="mapa__heading">DevWebCamp</h2>
            <p class="mapa__texto">Paseo Cultural, La Rioja, Argentina</p>
        `)
        .openPopup();
}

 
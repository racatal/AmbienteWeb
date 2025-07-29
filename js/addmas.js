document.addEventListener('DOMContentLoaded', () => {
  const form       = document.getElementById('formAddPet');
  const gallery    = document.getElementById('gallery');
  const totalCount = document.getElementById('totalCount');
  if (!form) return;

  form.addEventListener('submit', async e => {
    e.preventDefault();
    const fd = new FormData(form);
    const data = {};
    fd.forEach((v, k) => data[k] = v);

    try {
      const res  = await fetch('add_animal.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
      });
      const json = await res.json();

      if (!json.success) {
        return alert(json.error || 'Error al agregar mascota.');
      }

      const a = json.animal;
      const col = document.createElement('div');
      col.className = 'col-sm-6 col-md-4 col-lg-3 pet-card';
      col.dataset.id = a.id;
      col.innerHTML = `
        <div class="card h-100 shadow-sm">
          <img src="${a.foto}" class="card-img-top" alt="${a.tipo}">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">${a.tipo}</h5>
            <p class="card-text mb-4">
              Raza: ${a.raza || 'N/A'}<br>
              Color: ${a.color || 'N/A'}<br>
              Tamaño: ${a.tamanio || 'N/A'}<br>
              Fecha: ${a.fecha_encontrado || 'N/A'}<br>
              Lugar: ${a.lugar || 'N/A'}
            </p>
            <div class="mt-auto d-grid gap-2">
              <a href="detalle.php?id=${a.id}" class="btn btn-secondary">Detalles</a>
              <button class="btn btn-success btn-reclaim">Reclamar</button>
            </div>
          </div>
        </div>
      `;
      gallery.prepend(col);
      totalCount.textContent = Number(totalCount.textContent) + 1;
      form.reset();
      // cierra el collapse si lo usas
      const collapseEl = document.getElementById('addForm');
      if (collapseEl) new bootstrap.Collapse(collapseEl).hide();
    } catch (err) {
      console.error(err);
      alert('Error de comunicación con el servidor.');
    }
  });
});

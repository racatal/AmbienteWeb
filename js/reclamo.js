document.addEventListener('DOMContentLoaded', () => {
  const gallery    = document.getElementById('gallery');
  const totalCount = document.getElementById('totalCount');
  if (!gallery) return;

  gallery.addEventListener('click', async e => {
    if (!e.target.classList.contains('btn-reclaim')) return;
    const id = e.target.closest('.pet-card').dataset.id;
    if (!id) return;
    if (!confirm('¿Deseas reclamar esta mascota?')) return;

    try {
      const res  = await fetch('reclamo_animal.php', {
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body:JSON.stringify({id:+id})
      });
      const json = await res.json();
      if (!json.success) {
        return alert(json.error||'Error al reclamar');
      }
      e.target.closest('.pet-card').remove();
      totalCount.textContent = Number(totalCount.textContent)-1;
      alert('Mascota reclamada con éxito.');
    } catch(err) {
      console.error(err);
      alert('Error en la petición.');
    }
  });
});

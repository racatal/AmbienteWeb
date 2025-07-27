// js/detalle.js
document.addEventListener('DOMContentLoaded', () => {
  const btn = document.getElementById('btnReclaim');
  if (!btn) return;

  btn.addEventListener('click', async () => {
    const id = btn.getAttribute('data-id');
    if (!id || isNaN(id)) return;

    if (!confirm('¿Deseas reclamar esta mascota?')) return;

    try {
      const res  = await fetch('reclaim_pet.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: Number(id) })
      });
      const data = await res.json();

      if (data.success) {
        // Al reclamar, recarga la página para actualizar el estado
        alert('Mascota reclamada con éxito.');
        location.reload();
      } else {
        alert(data.error || 'Error al reclamar la mascota.');
      }
    } catch (err) {
      console.error(err);
      alert('Error en la petición.');
    }
  });
});

document.addEventListener('DOMContentLoaded', () => {
 
  const btnReclamar = document.querySelector('.btn-reclaim');
  if (btnReclamar) {
    btnReclamar.addEventListener('click', async () => {
      const params = new URLSearchParams(window.location.search);
      const id = Number(params.get('id'));
      if (!id) return;

      btnReclamar.disabled = true;
      btnReclamar.textContent = 'Reclamando…';

      try {
        const response = await fetch('reclamo_animal.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ id })
        });

        const result = await response.json();

        if (response.ok && result.success) {
          btnReclamar.textContent = 'Reclamado';
          btnReclamar.classList.replace('btn-success', 'btn-secondary');
        } else {
          throw new Error(result.error || 'No se pudo procesar el reclamo');
        }
      } catch (err) {
        alert(err.message);
        btnReclamar.disabled = false;
        btnReclamar.textContent = 'Reclamar';
      }
    });
  }

});

document.addEventListener('DOMContentLoaded', () => {
  const form   = document.getElementById('my-form');
  const status = document.getElementById('my-form-status');

  form.addEventListener('submit', async e => {
    e.preventDefault();
    e.stopPropagation();

    // Validación de Bootstrap
    if (!form.checkValidity()) {
      form.classList.add('was-validated');
      return;
    }

    // Envío asíncrono a Formspree
    const data = new FormData(form);
    try {
      const response = await fetch(form.action, {
        method: form.method,
        body: data,
        headers: { 'Accept': 'application/json' }
      });

      if (response.ok) {
        status.textContent = '¡Gracias por tu mensaje!';
        status.classList.remove('text-danger');
        status.classList.add('text-success');
        form.reset();
        form.classList.remove('was-validated');
      } else {
        const result = await response.json();
        status.textContent = result.errors
          ? result.errors.map(e => e.message).join(', ')
          : 'Ups! Hubo un problema al enviar tu mensaje.';
        status.classList.remove('text-success');
        status.classList.add('text-danger');
      }
    } catch (error) {
      console.error(error);
      status.textContent = 'Ups! Hubo un problema al enviar tu mensaje.';
      status.classList.remove('text-success');
      status.classList.add('text-danger');
    }
  });
});

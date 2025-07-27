document.addEventListener('DOMContentLoaded', () => {
  const input     = document.getElementById('contrasena');
  const btnToggle = document.getElementById('btn-toggle-contrasena');
  const icon      = document.getElementById('icon-contrasena');

  btnToggle.addEventListener('click', () => {
    const isPassword = input.type === 'password';
    input.type = isPassword ? 'text' : 'password';

   
    icon.classList.replace(
      isPassword ? 'fa-eye' : 'fa-eye-slash',
      isPassword ? 'fa-eye-slash' : 'fa-eye'
    );

    btnToggle.setAttribute(
      'aria-label',
      isPassword ? 'Ocultar contraseña' : 'Mostrar contraseña'
    );
  });
});

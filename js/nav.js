
  document.addEventListener('DOMContentLoaded', () => {
    const url = window.location.pathname.split('/').pop();
    document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
      if (link.getAttribute('href') === url) {
        link.classList.add('active');
      }
    });
  });

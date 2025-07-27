    document.addEventListener('DOMContentLoaded', () => {
 
      const currentPage = location.pathname.split('/').pop();
      document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
        const hrefPage = link.getAttribute('href').split('/').pop();
        if (hrefPage === currentPage) {
          link.classList.add('active');
        }
      });
    });
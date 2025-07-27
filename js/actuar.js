document.addEventListener('DOMContentLoaded', () => {
      // Sticky navbar
      const nav = document.querySelector('.navbar');
      window.addEventListener('scroll', () => {
        nav.classList.toggle('scrolled', window.scrollY > 50);
      });

      // Activar link
      const page = location.pathname.split('/').pop();
      document.querySelectorAll('.navbar-nav .nav-link').forEach(a => {
        if (a.getAttribute('href') === page) a.classList.add('active');
      });

      // Scroll reveal
      const obs = new IntersectionObserver(entries => {
        entries.forEach(({ isIntersecting, target }) => {
          if (isIntersecting) {
            target.classList.add('visible');
            obs.unobserve(target);
          }
        });
      }, { threshold: 0.1 });
      document.querySelectorAll('.reveal').forEach(el => obs.observe(el));

      // Back to Top
      const btn = document.getElementById('backToTop');
      window.addEventListener('scroll', () => {
        btn.style.display = window.scrollY > 300 ? 'flex' : 'none';
      });
      btn.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
      });

      // Theme Toggle
      const toggle = document.getElementById('themeToggle');
      const apply = m => {
        document.documentElement.setAttribute('data-theme', m);
        toggle.textContent = m==='light'?'🌙':'☀️';
      };
      let theme = localStorage.getItem('theme') || 'light';
      apply(theme);
      toggle.addEventListener('click', () => {
        theme = theme==='light'?'dark':'light';
        localStorage.setItem('theme', theme);
        apply(theme);
      });
    });
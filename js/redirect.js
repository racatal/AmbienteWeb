document.addEventListener('DOMContentLoaded', () => {

  document.querySelectorAll('.btn-reclaim-redirect').forEach(btn => {
    btn.addEventListener('click', () => {
      window.location.href = 'login.php';
    });
  });


});

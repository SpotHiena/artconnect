document.addEventListener('DOMContentLoaded', () => {
  // Menu hamburguer para qualquer nav
  const menuToggles = document.querySelectorAll('.menu-toggle');

  menuToggles.forEach(toggle => {
    const nav = toggle.closest('nav'); // encontra o nav mais próximo
    const menu = nav ? nav.querySelector('ul') : null;

    if (menu) {
      toggle.addEventListener('click', () => {
        menu.classList.toggle('show');
      });
    }
  });

  // Dropdown mobile em qualquer nav
  const dropdowns = document.querySelectorAll('.dropdown');
  dropdowns.forEach(drop => {
    const toggle = drop.querySelector('.dropdown-toggle');
    toggle.addEventListener('click', e => {
      if (window.innerWidth <= 768) {
        e.preventDefault();
        drop.classList.toggle('show');
      }
    });
  });
});

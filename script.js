const toggle = document.getElementById('langToggle');
const menu = document.getElementById('langMenu');

if (toggle && menu) {
  toggle.addEventListener('click', () => {
    menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
  });

  document.addEventListener('click', (e) => {
    if (!e.target.closest('.language-selector')) {
      menu.style.display = 'none';
    }
  });
}

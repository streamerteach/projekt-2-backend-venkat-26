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

//to hide and show profile manage tesxts
function toggleText(id){
  const element = document.getElementById(id);
  if(element.style.display === "none" || element.style.display === ""){
    element.style.display = "block";
  } else {
    element.style.display = "none";
  }
}
// Função para tornar a navegação responsiva
function toggleMenu() {
    const nav = document.querySelector('nav');
    nav.classList.toggle('active');
  }
  
  const logo = document.querySelector('.logo');
  logo.addEventListener('click', toggleMenu);

  
  
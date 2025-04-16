document.addEventListener("DOMContentLoaded", function () {
  const prevButton = document.querySelector(".prev");
  const nextButton = document.querySelector(".next");
  const slides = document.querySelectorAll(".slide");
  let currentIndex = 0;

  document.addEventListener("DOMContentLoaded", function () {
    const hamburger = document.getElementById("hamburger");
    const navLinks = document.getElementById("navLinks");

    hamburger.addEventListener("click", function () {
      navLinks.classList.toggle("show");
    });
  });

  // Función para mostrar la diapositiva correspondiente
  function showSlide(index) {
    // Ocultar todas las diapositivas
    slides.forEach((slide) => {
      slide.style.display = "none";
    });

    // Mostrar la diapositiva actual
    slides[index].style.display = "block";
  }

  // Evento para el botón "prev"
  prevButton.addEventListener("click", function () {
    currentIndex = (currentIndex - 1 + slides.length) % slides.length;
    showSlide(currentIndex);
  });

  // Evento para el botón "next"
  nextButton.addEventListener("click", function () {
    currentIndex = (currentIndex + 1) % slides.length;
    showSlide(currentIndex);
  });

  // Mostrar la primera diapositiva al cargar
  showSlide(currentIndex);

  // Cambio automático cada 5 segundos
  setInterval(function () {
    currentIndex = (currentIndex + 1) % slides.length;
    showSlide(currentIndex);
  }, 5000); // 5000ms = 5 segundos
});

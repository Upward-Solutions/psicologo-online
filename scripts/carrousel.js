document.addEventListener("DOMContentLoaded", function () {
  const track = document.querySelector(".carousel-track");
  const slides = Array.from(document.querySelectorAll(".carousel-slide"));
  const prevButton = document.querySelector(".carousel-button.prev");
  const nextButton = document.querySelector(".carousel-button.next");
  let currentIndex = 0;

  // ✅ Función para actualizar imagen según tamaño de pantalla
  function updateFirstSlideImage() {
    if (window.innerWidth <= 480) {
      slides[0].style.backgroundImage = "url('./assets/05.jpg')";
    } else {
      slides[0].style.backgroundImage = "url('./assets/02.jpg')";
    }
  }

  // 🖼️ Actualiza la imagen inicial
  updateFirstSlideImage();

  function updateSlidePosition() {
    const slideWidth = slides[0].offsetWidth;
    track.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
  }

  nextButton.addEventListener("click", () => {
    currentIndex = (currentIndex + 1) % slides.length;
    updateSlidePosition();
  });

  prevButton.addEventListener("click", () => {
    currentIndex = (currentIndex - 1 + slides.length) % slides.length;
    updateSlidePosition();
  });

  // 🔄 Auto slide
  setInterval(() => {
    currentIndex = (currentIndex + 1) % slides.length;
    updateSlidePosition();
  }, 5000);

  // 📐 Recalcula imagen y posición al redimensionar
  window.addEventListener("resize", () => {
    updateFirstSlideImage();
    updateSlidePosition();
  });

  updateSlidePosition(); // Inicial
});

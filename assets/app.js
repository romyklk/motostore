//import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

// Start Alpine.js
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();



// Menu mobile
document.addEventListener('DOMContentLoaded', function () {
  const button = document.getElementById('navbar-toggle');
  const menu = document.getElementById('navbar-default');

  button.addEventListener('click', function () {
    menu.classList.toggle('hidden');
  });
});


let currentSlide = 0;

function prevSlide() {
  const slides = document.querySelectorAll('.testimonial-slide');
  slides[currentSlide].style.transform = 'translateX(100%)';
  currentSlide = (currentSlide - 1 + slides.length) % slides.length;
  slides[currentSlide].style.transform = 'translateX(0)';
}

function nextSlide() {
  const slides = document.querySelectorAll('.testimonial-slide');
  slides[currentSlide].style.transform = 'translateX(-100%)';
  currentSlide = (currentSlide + 1) % slides.length;
  slides[currentSlide].style.transform = 'translateX(0)';
}










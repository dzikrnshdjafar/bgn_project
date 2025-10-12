document.addEventListener("DOMContentLoaded", () => {
    const hamburgerButton = document.getElementById("hamburgerButton");
    const navMenu = document.getElementById("navMenu");

    hamburgerButton.addEventListener("click", () => {
      
      navMenu.classList.toggle("hidden");
    });
  });
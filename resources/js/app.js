import "./bootstrap";

// Alpine.js for small interactions and animations
import Alpine from "alpinejs";
window.Alpine = Alpine;
Alpine.start();

// Simple auto-dismiss flash messages
window.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll("[data-flash]")?.forEach((el) => {
        setTimeout(() => {
            el.classList.add("opacity-0", "translate-y-2");
            setTimeout(() => el.remove(), 300);
        }, 2800);
    });
});

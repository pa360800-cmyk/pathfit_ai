import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

// Password toggle functionality
function togglePassword() {
    const passwordInput = document.getElementById("password");
    const type =
        passwordInput.getAttribute("type") === "password" ? "text" : "password";
    passwordInput.setAttribute("type", type);
}

function togglePasswordConfirmation() {
    const passwordInput = document.getElementById("password_confirmation");
    const type =
        passwordInput.getAttribute("type") === "password" ? "text" : "password";
    passwordInput.setAttribute("type", type);
}

// Make functions globally available
window.togglePassword = togglePassword;
window.togglePasswordConfirmation = togglePasswordConfirmation;

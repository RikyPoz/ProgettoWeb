document.addEventListener("DOMContentLoaded", function() {
    const modal = document.getElementById("myModal");
    const btn = document.getElementById("openModal");
    const span = document.querySelector(".close");

    // Mostra il modale
    btn.onclick = function() {
        modal.style.display = "block";
        modal.setAttribute("aria-hidden", "false");
    };

    // Nasconde il modale
    span.onclick = function() {
        modal.style.display = "none";
        modal.setAttribute("aria-hidden", "true");
    };

    // Chiude il modale cliccando all'esterno
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
            modal.setAttribute("aria-hidden", "true");
        }
    };
});

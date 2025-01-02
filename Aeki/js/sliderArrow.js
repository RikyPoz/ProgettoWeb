document.addEventListener("DOMContentLoaded", function () {
    function enableHorizontalScroll(sliderId, leftButtonId, rightButtonId) {
        const slider = document.getElementById(sliderId);
        const leftButton = document.getElementById(leftButtonId);
        const rightButton = document.getElementById(rightButtonId);
        let currentScrollPosition = 0;
        const scrollAmount = 300; // Di quanto si scorre ogni volta
        
        // Aggiornare lo stato dei pulsanti
        function updateButtonState() {
            const maxScroll = slider.scrollWidth - slider.offsetWidth;

            leftButton.disabled = currentScrollPosition <= 0;
            rightButton.disabled = currentScrollPosition >= maxScroll;
        }

        updateButtonState();

        rightButton.addEventListener("click", function () {
            const maxScroll = slider.scrollWidth - slider.offsetWidth;
            if (currentScrollPosition < maxScroll) {
                currentScrollPosition += scrollAmount;
                if (currentScrollPosition > maxScroll) {
                    currentScrollPosition = maxScroll;
                }
                slider.style.transform = `translateX(-${currentScrollPosition}px)`;
            }
            updateButtonState();
        });

        leftButton.addEventListener("click", function () {
            if (currentScrollPosition > 0) {
                currentScrollPosition -= scrollAmount;
                if (currentScrollPosition < 0) {
                    currentScrollPosition = 0;
                }
                slider.style.transform = `translateX(-${currentScrollPosition}px)`;
            }
            updateButtonState();
        });
    }

    // Abilitare lo scorrimento per Categorie
    enableHorizontalScroll("categoriesSlider", "categoriesLeft", "categoriesRight");
    // Abilitare lo scorrimento per Ambienti
    enableHorizontalScroll("ambientSlider", "ambientLeft", "ambientRight");
});

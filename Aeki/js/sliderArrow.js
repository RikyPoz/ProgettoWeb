document.addEventListener("DOMContentLoaded", function () {
    function enableHorizontalScroll(sliderContainer) {
        const slider = sliderContainer.querySelector(".slider-track");
        const leftButton = sliderContainer.querySelector(".slider-button-left");
        const rightButton = sliderContainer.querySelector(".slider-button-right");
        let currentScrollPosition = 0;
        const scrollAmount = 300;

        // Nascondi le frecce e abilita il tocco su mobile
        if (window.innerWidth <= 768) {
            slider.style.overflowX = "auto";
            slider.style.webkitOverflowScrolling = "touch";
            return;
        }

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

    const sliderContainers = document.querySelectorAll(".slider-container");
    sliderContainers.forEach(enableHorizontalScroll);
});

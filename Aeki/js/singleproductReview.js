document.addEventListener("DOMContentLoaded", () => {
    const toggleBtn = document.getElementById("toggle-reviews-btn");
    const reviewsContainer = document.getElementById("reviews-container");
    const toggleIcon = document.getElementById("toggle-icon");

    toggleBtn.addEventListener("click", () => {
        reviewsContainer.classList.toggle("d-none");
        if (reviewsContainer.classList.contains("d-none")) {
            toggleIcon.classList.remove("bi-chevron-up");
            toggleIcon.classList.add("bi-chevron-down");
        } else {
            toggleIcon.classList.remove("bi-chevron-down");
            toggleIcon.classList.add("bi-chevron-up");
        }
    });
});
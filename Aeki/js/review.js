document.addEventListener("DOMContentLoaded", function () {
    const stars = document.querySelectorAll('#rating i');
    const ratingValueInput = document.getElementById('rating-value-input');
    const ratingText = document.getElementById('rating-value');

    stars.forEach(star => {
        star.addEventListener("click", function () {
            const selectedValue = this.getAttribute("data-value");

            stars.forEach(s => s.classList.replace("text-warning", "text-secondary"));

            stars.forEach(s => {
                if (s.getAttribute("data-value") <= selectedValue) {
                    s.classList.replace("text-secondary", "text-warning");
                }
            });

            ratingText.textContent = `${selectedValue}`;
            ratingValueInput.value = selectedValue;
        });
    });

    document.getElementById("review-form").addEventListener("submit", async function (event) {
        event.preventDefault();

        const formData = new FormData(this);
        const formObject = {};

        formData.forEach((value, key) => {
            formObject[key] = value;
        });

        const sendingData = {
            productId: formObject["productId"],
            rating: formObject["rating"],
            comment: formObject["comment"]
        };

        try {
            const response = await fetch('submitreview.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(sendingData)
            });

            if (!response.ok) {
                throw new Error(`Errore nella richiesta: ${response.status}`);
            }


            const result = await response.json();
            console.log(result);

            if (result.success) {
                alert(result.message);
                window.location.href = 'orderList.php';
            } else {
                alert(result.message);
            }
        } catch (error) {
            console.error('Errore nell\'invio della recensione:', error);
            alert('Errore nell\'invio della recensione');
        }
    });

});





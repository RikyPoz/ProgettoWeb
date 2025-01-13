document.addEventListener("DOMContentLoaded", function () {
    addToCartEventListener();
});


function addToCartEventListener() {
    const addToCartButton = document.querySelector("#addToCartButton");

    addToCartButton.addEventListener("click", async function () {
        const productId = addToCartButton.getAttribute("data-id");
        const quantity = document.querySelector("#quantity").value;
        const userType = document.querySelector("#userType").getAttribute("data-user-type");

        if (userType === "Venditore") {
            alert("Sei Un Venditore")
            return;
        }
        const data = {
            productId: productId,
            quantity: quantity
        };

        try {
            const response = await fetch('Ajax/shoppingCart/api-addToCart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });

            if (!response.ok) {
                throw new Error(`Errore nella richiesta: ${response.status}`);
            }

            const json = await response.json();

            if (json.success) {
                console.log("tutto ok");
                alert("aggiunto");
            } else {
                console.log("Errore nell'aggiunta al carrello");
                if (json.error === 'not_logged_in') {
                    alert(json.message);
                } else {
                    alert("Si è verificato un errore: " + json.message);
                }
            }

        } catch (error) {
            console.log(error.message);
        }
    });
}




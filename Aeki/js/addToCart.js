const addToCartButton = document.querySelector("#addToCartButton");

addToCartButton.addEventListener("click", async function () {
    const productId = new URLSearchParams(window.location.search).get("id"); // Prendi l'ID del prodotto dalla URL
    const quantity = document.querySelector("#quantity").value; // Prendi la quantità selezionata

    // Prepara i dati da inviare al server
    const data = {
        productId: productId,
        quantity: quantity
    };

    try {
        //richiesta AJAX per aggiungere il prodotto al carrello
        const response = await fetch('Ajax/api-addToCart.php', {
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
            aggiornaCarrello(json.carrello);
        } else {
            console.log("Errore nell'aggiunta al carrello");
            if (json.error === 'not_logged_in') {
                //per gestire utente non loggato
                alert(json.message);
            } else {
                //per altri errori
                alert("Si è verificato un errore: " + json.message);
            }
        }

    } catch (error) {
        console.log(error.message);
    }
});

//da modificare, potrebbe anche non mostrare niente
function aggiornaCarrello(carrello) {
    document.querySelector("#cart-count").textContent = carrello.numeroProdotti;
    document.querySelector("#cart-total").textContent = carrello.totale;
}

// il codice viene eseguito dopo che il DOM è stato caricato
document.addEventListener("DOMContentLoaded", function () {
    addLikeBtnListener();
});

function addLikeBtnListener() {
    const heartButtons = document.querySelectorAll(".btn");

    heartButtons.forEach(button => {
        button.addEventListener("click", function () {
            const heartIcon = button.querySelector("i");
            const prodottoId = button.getAttribute("data-id");

            if (heartIcon.classList.contains("text-danger")) {
                heartIcon.classList.remove("text-danger");
                heartIcon.classList.add("text-white");
                rimuoviDalDatabase(prodottoId);
            } else {
                heartIcon.classList.remove("text-white");
                heartIcon.classList.add("text-danger");
                aggiungiAlDatabase(prodottoId);
            }
        });
    });
}

async function rimuoviDaWishlist(prodottoId) {
    try {
        const response = await fetch('/rimuoviProdotto', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ prodottoId })
        });

        if (!response.ok) {
            throw new Error(`Errore nella richiesta: ${response.status}`);
        }

        const data = await response.json();
        if (data.success) {
            console.log('Prodotto rimosso:', data);
        } else {
            console.error('Errore specifico:', data.message);
            if (data.error === 'not_logged_in') {
                alert('Utente non loggato. Effettua il login.');
            } else {
                alert('Errore: ' + data.message);
            }
        }
    } catch (error) {
        console.error('Errore nella rimozione del prodotto:', error);
    }
}




async function aggiungiAWishlist(prodottoId) {
    try {
        const response = await fetch('/aggiungiProdotto', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ prodottoId })
        });

        if (!response.ok) {
            throw new Error(`Errore nella richiesta: ${response.status}`);
        }

        const data = await response.json();

        if (data.success) {
            console.log('Prodotto aggiunto:', data);
        } else {
            console.error('Errore specifico:', data.message);
            if (data.error === 'not_logged_in') {
                alert('Utente non loggato. Effettua il login.');
            } else {
                alert('Errore: ' + data.message);
            }
        }
    } catch (error) {
        console.error('Errore generale:', error);
    }
}


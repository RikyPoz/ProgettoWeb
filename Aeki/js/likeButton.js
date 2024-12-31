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
                rimuoviDaWishlist(prodottoId).then(success => {
                    if (success) {
                        heartIcon.classList.remove("text-danger");
                        heartIcon.classList.add("text-white");
                    }
                });
            } else {
                aggiungiAWishlist(prodottoId).then(success => {
                    if (success) {
                        heartIcon.classList.remove("text-white");
                        heartIcon.classList.add("text-danger");
                    }
                });
            }
        });
    });
}


async function rimuoviDaWishlist(prodottoId) {
    try {
        const sendingData = {
            productId: prodottoId,
            type: "remove"
        };
        const response = await fetch('Ajax/api-likeButton.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(sendingData)
        });

        if (!response.ok) {
            throw new Error(`Errore nella richiesta: ${response.status}`);
        }

        const data = await response.json();
        if (data.success) {
            console.log('Prodotto rimosso:', data);
            return true;
        } else {
            console.error('Errore specifico:', data.message);
            if (data.error === 'not_logged_in') {
                alert('Utente non loggato. Effettua il login.');
            } else {
                alert('Errore: ' + data.message);
            }
            return false;
        }

    } catch (error) {
        console.error('Errore nella rimozione del prodotto:', error);
        return false;
    }
}

async function aggiungiAWishlist(prodottoId) {
    try {
        const sendingData = {
            productId: prodottoId,
            type: "add"
        };
        const response = await fetch('Ajax/api-likeButton.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(sendingData)
        });

        if (!response.ok) {
            throw new Error(`Errore nella richiesta: ${response.status}`);
        }

        const data = await response.json();

        if (data.success) {
            console.log('Prodotto aggiunto:', data);
            return true;
        } else {
            console.error('Errore specifico:', data.message);
            if (data.error === 'not_logged_in') {
                alert('Utente non loggato. Effettua il login.');
            } else {
                alert('Errore: ' + data.message);
            }
            return false;
        }
    } catch (error) {
        console.error('Errore nell aggiunta del prodotto :', error);
        return false;
    }
}

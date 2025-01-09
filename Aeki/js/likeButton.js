document.addEventListener("DOMContentLoaded", function () {
    addLikeBtnListener();
});

function addLikeBtnListener() {
    const heartIcons = document.querySelectorAll(".bi-heart, .bi-heart-fill"); //sia vuote che piene

    heartIcons.forEach(icon => {
        icon.addEventListener("click", function () {
            const prodottoId = icon.getAttribute("data-id");
            const userType = document.querySelector("#userType").getAttribute("data-user-type");

            if (userType === "Venditore") {
                alert("Sei Un Venditore")
                return;
            }

            if (icon.classList.contains("bi-heart")) { //se è vuota
                aggiungiAWishlist(prodottoId).then(success => {
                    if (success) {
                        icon.style.display = "none";
                        const heartFillIcon = document.querySelector(`.bi-heart-fill[data-id="${prodottoId}"]`);
                        heartFillIcon.style.display = "inline-block";
                    }
                });
            } else {
                rimuoviDaWishlist(prodottoId).then(success => {
                    if (success) {
                        icon.style.display = "none";
                        const heartIcon = document.querySelector(`.bi-heart[data-id="${prodottoId}"]`);
                        heartIcon.style.display = "inline-block";
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
        console.log(sendingData);
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
                alert(data.message);
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
        console.log(sendingData);
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

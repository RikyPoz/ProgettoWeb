async function addModalEventListener() {
    const saveProductBtn = document.getElementById("saveProductBtn");

    saveProductBtn.addEventListener("click", async function () {
        const nome = document.getElementById("productName").value.trim();
        const prezzo = document.getElementById("productPrice").value.trim();
        const descrizione = document.getElementById("productDescription").value.trim();
        const materiale = document.getElementById("productMaterial").value.trim();
        const colore = document.getElementById("productColor").value.trim();
        const ambiente = document.getElementById("productEnvironment").value.trim();
        const categoria = document.getElementById("productCategory").value.trim();
        const altezza = document.getElementById("productHeight").value.trim();
        const larghezza = document.getElementById("productWidth").value.trim();
        const profondita = document.getElementById("productDepth").value.trim();
        const peso = document.getElementById("productWeight").value.trim();
        const productImage1 = document.getElementById("productImage1").files[0];

        if (!nome || !prezzo || !descrizione || !materiale || !colore || !ambiente || !categoria || !altezza || !larghezza || !profondita) {
            alert("Compila tutti i campi prima di salvare il prodotto.");
            return;
        }

        if (!productImage1) {
            alert("L'immagine icona è obbligatoria");
            return;
        }

        const paths = await insertImages();

        if (paths) {
            console.log('Percorsi delle immagini:', paths);
        } else {
            alert('Errore nel caricamento delle immagini');
            return;
        }

        const sendingData = {
            action: 'add-product',
            nome: nome,
            prezzo: prezzo,
            descrizione: descrizione,
            percorsoImgs: paths,
            larghezza: larghezza,
            altezza: altezza,
            profondita: profondita,
            ambiente: ambiente,
            categoria: categoria,
            colore: colore,
            materiale: materiale,
            peso: peso
        };

        try {
            const response = await fetch('Ajax/api-seller-product.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(sendingData)
            });

            if (!response.ok) {
                throw new Error(`Errore nella richiesta: ${response.status}`);
            }

            const result = await response.json();
            console.log(result);
            if (result.success) {
                alert("Prodotto aggiunto con successo!");
                fetchData("products");
                document.getElementById("addProductModalClose").click();
            } else {
                alert("Errore durante l'aggiunta del prodotto: " + result.message);
            }
        } catch (error) {
            console.error("Errore durante l'invio dei dati:", error);
            alert("Errore durante l'aggiunta del prodotto. Riprova.");
        }
    });
}

async function updateModalEventListeners(product) {
    const modals = document.querySelectorAll(`#updateAvailabilityModal-${product.CodiceProdotto}, #deleteProductModal-${product.CodiceProdotto}, #updateProductModal-${product.CodiceProdotto}`);

    const rifornisciButton = modals[0]?.querySelector('.btn-primary');
    const eliminaButton = modals[1]?.querySelector('.btn-danger');
    const modificaButton = modals[2]?.querySelector('.btn-primary');

    if (rifornisciButton && eliminaButton && modificaButton) {
        rifornisciButton.addEventListener('click', () => updateProductAvailability(product));
        eliminaButton.addEventListener('click', () => deleteProduct(product));
        modificaButton.addEventListener('click', () => updateProductPrice(product));
    } else {
        console.error(`I bottoni per il prodotto ${product.CodiceProdotto} non sono stati trovati`);
    }
}


async function updateProductAvailability(product) {
    const newAvailability = document.querySelector(`#newAvailability-${product.CodiceProdotto}`).value;
    if (!newAvailability) {
        alert('Seleziona una nuova disponibilità.');
        return;
    }

    try {

        const sendingData = {
            action: 'update-availability',
            codiceProdotto: product.CodiceProdotto,
            nuovaDisponibilita: newAvailability
        };


        const response = await fetch('Ajax/api-seller-product.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(sendingData)
        });

        if (!response.ok) {
            throw new Error(`Errore nella richiesta: ${response.status}`);
        }

        const result = await response.json();

        if (result.success) {
            alert('Disponibilità aggiornata');
            const closeButton = document.querySelector(`#updateAvailabilityModal-${product.CodiceProdotto} .btn-close`);
            closeButton.click();
            fetchData("products");
        } else {
            alert("Errore durante l'aggiornamento del prodotto: " + result.message);
        }
    } catch (error) {
        console.error('Errore nella richiesta:', error);
        alert('Errore nel comunicare con il server');
    }
}


async function deleteProduct(product) {
    try {

        const sendingData = {
            action: 'delete-product',
            codiceProdotto: product.CodiceProdotto,
        };

        const response = await fetch('Ajax/api-seller-product.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(sendingData)
        });


        if (!response.ok) {
            throw new Error(`Errore nella richiesta: ${response.status}`);
        }

        const result = await response.json();

        if (result.success) {
            alert('Prodotto eliminato');
            const closeButton = document.querySelector(`#deleteProductModal-${product.CodiceProdotto} .btn-close`);
            closeButton.click();
            fetchData("products");
        } else {
            alert('Errore durante l\'eliminazione del prodotto ' + result.message);
        }
    } catch (error) {
        console.error('Errore nella richiesta:', error);
        alert('Errore nel comunicare con il server');
    }
}


async function updateProductPrice(product) {
    const newPrice = document.querySelector(`#newPrice-${product.CodiceProdotto}`).value;
    if (!newPrice) {
        alert('Inserisci un nuovo prezzo.');
        return;
    }

    try {

        const sendingData = {
            action: 'update-price',
            codiceProdotto: product.CodiceProdotto,
            nuovoPrezzo: newPrice
        };

        const response = await fetch('Ajax/api-seller-product.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(sendingData)
        });

        if (!response.ok) {
            throw new Error(`Errore nella richiesta: ${response.status}`);
        }

        const result = await response.json();


        if (result.success) {
            alert('Prezzo aggiornato');
            const closeButton = document.querySelector(`#updateProductModal-${product.CodiceProdotto} .btn-close`);
            closeButton.click();
            fetchData("products");
        } else {
            alert('Errore durante l\'aggiornamento del prezzo' + result.message);
        }
    } catch (error) {
        console.error('Errore nella richiesta:', error);
        alert('Errore nel comunicare con il server');
    }
}

async function insertImages() {
    const productImage1 = document.getElementById("productImage1").files[0];
    const productImage2 = document.getElementById("productImage2").files[0];
    const productImage3 = document.getElementById("productImage3").files[0];

    const formData = new FormData();

    if (productImage1) {
        formData.append("productImage1", productImage1);
    }
    else {
        return null;
    }

    if (productImage2) formData.append("productImage2", productImage2);
    if (productImage3) formData.append("productImage3", productImage3);

    try {
        const response = await fetch('uploadImg.php', {
            method: 'POST',
            body: formData,
        });

        const data = await response.json();

        if (data.success) {
            console.log('Immagini caricate con successo:', data.paths);
            return data.paths;
        } else {
            console.error('Errore nel caricamento delle immagini:', data.message);
            return null;
        }

    } catch (error) {
        console.error('Errore nella comunicazione con il server:', error);
        return null;
    }
}






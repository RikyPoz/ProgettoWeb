function getResoconto(prices)  {
    return `<li class="list-group-item d-flex justify-content-between">
                <span>Articoli</span> 
                <span>€${prices["totNoIva"]}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span>IVA</span> 
                <span>€${prices["totIva"]}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span>Spedizione</span> 
                <span>€${prices["spedizione"]}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between fw-bold">
                <span>Totale</span> 
                <span>€${prices["tot"]}</span>
            </li>`
}

function aggiornaPrezziQuantita(codiceProdotto) {
    quantita = document.getElementById(codiceProdotto).value;
    document.getElementById(codiceProdotto+"Prezzo").textContent = quantita > 1 ? " x "+quantita : "";
    aggiornaRiepilogo();
}

function getCarrello(products) {
    let result = "";
    if (products.length == 0) {
        result = `  <div class="d-flex justify-content-center align-items-center" style="height: 55vh;">
                        <div class="text-center">
                            <img src="upload/noLike.png" alt="nessun mi piace" class="img-fluid">
                            <h3 class="text-muted mt-4">Nessun Mi Piace</h3>
                            <p>Non hai nessun prodotto nei preferiti</p>
                        </div>
                    </div>`
    } else {
        for(let i=0; i < products.length; i++){
            let quantitaHTML;
            const codiceProdotto = products[i]["CodiceProdotto"];
            const disponibilita = products[i]["Disponibilita"];
            const quantita = products[i]["Quantita"];

            if (disponibilita > 0) {
                quantitaHTML = `<input type="number" class="form-control form-control-sm w-auto text-center"
                                id="${codiceProdotto}"
                                value="${quantita}" 
                                max="${disponibilita}"
                                onchange="aggiornaPrezziQuantita(${codiceProdotto})"
                                min="1" style="max-width: 60px;"
                                onkeydown="return false;"/>`;
            } else {
                quantitaHTML = `<span class="text-danger fw-bold">Non disponibile</span>`;
            }

            let product = `
                        <div class="card mb-3">
                            <div class="row g-0 align-items-center">
                                <div class="col-3 col-md-2">
                                    <img src="${products[i]["PercorsoImg"]}" 
                                        class="img-fluid rounded-start img-fixed" alt="Prodotto">
                                </div>
                                <div class="col-9 col-md-10">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <!-- Nome prodotto e quantità -->
                                            <div class="d-flex align-items-center flex-wrap">
                                                <h5 class="card-title mb-0 me-3">${products[i]["Nome"]}</h5>
                                                ${quantitaHTML}
                                            </div>

                                            <!-- Checkbox e prezzo -->
                                            <div class="d-flex align-items-center">
                                                <input type="checkbox" class="form-check-input me-2 product-checkbox"
                                                    onchange="aggiornaRiepilogo()"
                                                    data-id="${codiceProdotto}"
                                                    ${disponibilita > 0 ? "checked" : "disabled"}/>
                                                <p class="mb-0 text-success fw-bold">
                                                    €${products[i]["Prezzo"]} 
                                                    <span id="${codiceProdotto}Prezzo">${quantita > 1 ? " x "+quantita : ""}</span>
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Bottoni -->
                                        <div class="mt-2 d-flex gap-2">
                                            <a href="singleProduct.php?id=${codiceProdotto}" 
                                            class="btn btn-outline-primary btn-sm">Visualizza Articolo</a>
                                            <button class="btn btn-outline-danger btn-sm" 
                                                onclick="rimuoviDalCarrello(${codiceProdotto})">Rimuovi</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
            result += product;
        }
        result += `<div class="text-end fw-bold sticky-bottom bg-light py-2 border-top" id="summary"></div>`;
    }
    return result;
}

function getSelezionati() {
    const selectedProducts = {}
    document.querySelectorAll('.product-checkbox:checked').forEach((checkbox) => {
        const id = checkbox.getAttribute('data-id');
        selectedProducts[id] = document.getElementById(id).value;
    });
    return selectedProducts;
}

async function aggiornaRiepilogo() {
    const selectedProducts = getSelezionati();
    try {
        const response = await fetch("Ajax/api-shoppingCartTots.php", {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(selectedProducts)
        });

        if (!response.ok) {
            throw new Error(`Errore nella richiesta: ${response.status}`);
        }
        const json = await response.json();
        document.getElementById("summary").textContent = `Totale (${json["numArticoli"]} articoli): €${json["tot"]}`;
        const recapTable = document.getElementById("recapTable");
        const recapTableMobile = document.getElementById("recapTableMobile");
        const resocontoHTML = getResoconto(json);
        recapTableMobile.innerHTML = resocontoHTML;
        recapTable.innerHTML = resocontoHTML;
        
    } catch (error) {
        console.log("Errore durante il caricamento del riepilogo carrello:", error.message);
    }
}

async function aggiornaCarrello() {
    try {
        const response = await fetch("Ajax/api-shoppingCart.php");

        if (!response.ok) {
            throw new Error(`Errore nella richiesta: ${response.status}`);
        }
        const json = await response.json();
        document.getElementById("cartTitle").textContent = `Carrello (${json.length})`;
        const productsContainer = document.getElementById("productsContainer");
        productsContainer.innerHTML = getCarrello(json);
        aggiornaRiepilogo();
        
    } catch (error) {
        console.log("Errore durante il caricamento dei prodotti del carrello:", error.message);
    }
}

async function rimuoviDalCarrello(id) {
    const data = { productId: id }
    try {
        const response = await fetch("Ajax/api-removeToCart.php", {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });

        if (!response.ok) {
            throw new Error(`Errore nella richiesta: ${response.status}`);
        }

        const json = await response.json();        
        if (json['success']) {
            aggiornaCarrello();
        } else {
            console.log(json['message']);
        }
    } catch (error) {
        console.log("Errore durante la rimozione del prodotto dal carrello:", error.message);
    }
}

async function salvaModifiche() {
        const selectedProducts = getSelezionati();
    try {
        const response = await fetch("Ajax/api-shoppingCartSave.php", {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(selectedProducts)
        });

        if (!response.ok) {
            throw new Error(`Errore nella richiesta: ${response.status}`);
        }
        const json = await response.json();
        const total = json['tot'];
        window.location.href = `checkout.php?tot=${total}`;
    } catch (error) {
        console.log("Errore durante la preparazione del checkout:", error.message);
    }
}

/**
 * Modale con :
 *  Riepilogo prodotti selezionati
 *  Scelta tipo spedizione
 *  Prezzo totale
 *  Pulsante acquista: Crea ordine, Rimuovi prodotti dal carrello, manda notifica al Seller
 * 
 * ALtro modale di successo, codice ordine con data stimata, pulsante torna alla Home o visualizza ordini
 */

document.getElementById('proceedToCheckout').addEventListener('click', salvaModifiche);

aggiornaCarrello();
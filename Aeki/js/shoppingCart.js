let productsFromId= [];
let tot;
let nArticoli = 0;
function aggiornaRiepilogo() {
    tot = 0;
    nArticoli = 0;
    productsFromId.forEach(product => {
        if (product["Selezionato"]) {
            tot += product["Prezzo"] * product["Quantita"];
            nArticoli += product["Quantita"];
        }
    });
    if (nArticoli > 0) {
        riepilogoHTML = `<div class="sticky-top" style="top: 1rem;">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Riepilogo</h5>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Articoli</span> 
                                            <span>€${tot * 0.88}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>IVA</span> 
                                            <span>€${tot * 0.22}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between fw-bold">
                                            <span>Totale</span> 
                                            <span>€${tot}</span>
                                        </li>
                                    </ul>
                                    <button class="btn btn-success w-100 mt-3" id="proceedToCheckout" onclick="salvaModifiche()">Procedi all'Acquisto</button>
                                </div>
                            </div>  
                        </div>`;
        summaryHTML = `Totale (${nArticoli} articoli): €${tot}`;
    } else {
        riepilogoHTML = "";
        summaryHTML = ``;
    }
    document.getElementById("recapTable").innerHTML = riepilogoHTML;
    document.getElementById("recapTableMobile").innerHTML = riepilogoHTML;
    document.getElementById("summary").textContent = summaryHTML;
}

function aggiornaPrezziQuantita(codiceProdotto) {
    quantita = document.getElementById(codiceProdotto).value;
    document.getElementById("moltiplicatore"+codiceProdotto).textContent = quantita > 1 ? " x "+quantita : "";
    productsFromId[codiceProdotto]["Quantita"] = Number(quantita);
    aggiornaRiepilogo();
}

function aggiornaSelezionato(codiceProdotto) {
    productsFromId[codiceProdotto]["Selezionato"] = !productsFromId[codiceProdotto]["Selezionato"];
    aggiornaRiepilogo();
}

function getCarrello(products) {
    let result = "";
    productsFromId = [];
    if (products.length == 0) {
        result = `  <div class="d-flex justify-content-center align-items-center" style="height: 55vh;">
                        <div class="text-center">
                            <img src="upload/noCartbg.png" alt="carrello triste" class="img-fluid">
                            <h3 class="text-muted mt-4">Carrello vuoto</h3>
                            <p>Non hai nessun prodotto nel carrello</p>
                        </div>
                    </div>`
    } else {
        for(let i=0; i < products.length; i++){
            let quantitaHTML;
            const codiceProdotto = ""+products[i]["CodiceProdotto"];
            const disponibilita = products[i]["Disponibilita"];
            const quantita = Number(products[i]["Quantita"]);
            const prezzo = products[i]["Prezzo"];
            const selezionato = products[i]["Selezionato"] == 'Y';
            const checkbox = disponibilita < 1 ? "disabled" : selezionato ? "checked" : "";
            const productElement = { Quantita: quantita, Disponibilita: disponibilita, Prezzo: prezzo, Selezionato: selezionato };
            productsFromId[codiceProdotto] = productElement;
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
                                                    onchange="aggiornaSelezionato(${codiceProdotto})"
                                                    data-id="${codiceProdotto}"
                                                    ${checkbox}/>
                                                <p class="mb-0 text-success fw-bold">
                                                    €${prezzo} 
                                                    <span id="moltiplicatore${codiceProdotto}">${quantita > 1 ? " x "+quantita : ""}</span>
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

function rimuoviDalCarrello(id) {
    const data = {
            operation: 'remove',
            productId: id
        }
    if (modificaCarrello(data)) {
        aggiornaCarrello();
    };
    
}

function salvaModifiche() {
    const data = {
        operation: 'save',
        products: productsFromId
    }
    if (modificaCarrello(data)) {
        procediAllAquisto();
    };
}

async function modificaCarrello(data) {
    try {
        const response = await fetch("Ajax/api-modifyCart.php", {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });

        if (!response.ok) {
            throw new Error(`Errore nella richiesta: ${response.status}`);
        }
        const json = await response.json();        
        if (json['success']) {
            return true;
        } else {
            console.log(json['message']);
        }
    } catch (error) {
        console.log("Errore durante la modifica del prodotto dal carrello:", error.message);
    }
    return false;
}

async function procediAllAquisto() {
    
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

aggiornaCarrello();
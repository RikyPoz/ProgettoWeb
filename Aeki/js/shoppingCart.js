let productsFromId = [];
let tot;
let nArticoli = 0;
let spedizione = {};
function aggiornaRiepilogo() {
    tot = 0;
    nArticoli = 0;
    productsFromId.forEach(product => {
        if (product["Selezionato"]) {
            tot += product["Prezzo"] * product["Quantita"];
            nArticoli += product["Quantita"];
        }
    });
    let totHTML;
    let riepilogoHTML;
    if (productsFromId.length > 0) {
        riepilogoHTML = `<div class="sticky-top" style="top: 1rem;">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Riepilogo</h5>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Articoli</span> 
                                            <span>€${(tot * 0.88).toFixed(2)}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>IVA</span> 
                                            <span>€${(tot * 0.22).toFixed(2)}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between fw-bold">
                                            <span>Totale</span> 
                                            <span>€${tot.toFixed(2)}</span>
                                        </li>
                                    </ul>
                                    <button class="btn w-100 mt-3" id="proceedToCheckout" onclick="salvaModifiche()" style ="background-color:#000060;color:#FFFFFF">Procedi all'Acquisto</button>
                                </div>
                            </div>  
                        </div>`;
        totHTML = `Totale (${nArticoli} articoli): €${tot.toFixed(2)}`;
    } else {
        riepilogoHTML = "";
        totHTML = ``;
    }
    document.getElementById("recapTable").innerHTML = riepilogoHTML;
    document.getElementById("recapTableMobile").innerHTML = riepilogoHTML;
    try {
        document.getElementById("tot").textContent = totHTML;
    } catch (error) { }
}

function aggiornaPrezziQuantita(codiceProdotto) {
    const input = document.getElementById(codiceProdotto);
    let quantita = input.value;
    const disponibilita = productsFromId[codiceProdotto]["Disponibilita"];
    if (disponibilita < quantita) {
        quantita = disponibilita;
        input.value = disponibilita;
    } else if (quantita < 1) {
        quantita = 1;
        input.value = 1;
    }
    document.getElementById("moltiplicatore" + codiceProdotto).textContent = quantita > 1 ? " x " + quantita : "";
    productsFromId[codiceProdotto]["Quantita"] = Number(quantita);
    aggiornaRiepilogo();
}

function aggiornaSelezionato(codiceProdotto) {
    productsFromId[codiceProdotto]["Selezionato"] = !productsFromId[codiceProdotto]["Selezionato"];
    aggiornaRiepilogo();
}

function aggiornaSpedizione() {
    const shippingType = document.getElementById('shippingType');
    const deliveryDateElement = document.getElementById('estimatedDelivery');
    const successDeliveryDateElement = document.getElementById('successDeliveryDate');

    if (!shippingType) {
        deliveryDateElement.textContent = '--';
        successDeliveryDateElement.textContent = 'Arrivo previsto: --';
        return;
    }
    const currentDate = new Date();
    const daysToAdd = shippingType.value === 'express' ? 2 : 7;
    const priceToAdd = shippingType.value === 'express' ? 10 : 5;
    spedizione["Giorni"] = daysToAdd;
    spedizione["Prezzo"] = priceToAdd;
    currentDate.setDate(currentDate.getDate() + daysToAdd);
    const formattedDate = currentDate.toLocaleDateString('it-IT', { year: 'numeric', month: 'long', day: 'numeric' });
    document.getElementById('totModal').textContent = (tot + priceToAdd).toFixed(2) + " €";
    deliveryDateElement.textContent = formattedDate;
    successDeliveryDateElement.textContent = `Arrivo previsto: ${formattedDate}`;
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
        for (let i = 0; i < products.length; i++) {
            let quantitaHTML;
            const codiceProdotto = "" + products[i]["CodiceProdotto"];
            const nome = products[i]["Nome"];
            const disponibilita = products[i]["Disponibilita"];
            const quantita = Number(products[i]["Quantita"]);
            const prezzo = products[i]["Prezzo"];
            let selezionato = products[i]["Selezionato"] == 'Y';
            const checkbox = disponibilita < 1 ? "disabled" : selezionato ? "checked" : "";

            if (disponibilita > 0) {
                quantitaHTML = `<input type="number" class="form-control form-control-sm rounded-pill w-auto text-center"
                                id="${codiceProdotto}"
                                value="${quantita}" 
                                max="${disponibilita}"
                                onchange="aggiornaPrezziQuantita(${codiceProdotto})"
                                min="1" style="max-width: 60px;"/>`;
            } else {
                quantitaHTML = `<span class="fw-bold"style="color:#B00000">Non disponibile</span>`;
                selezionato = false;
            }

            const productElement = { Quantita: quantita, Disponibilita: disponibilita, Prezzo: prezzo, Selezionato: selezionato, Nome: nome };
            productsFromId[codiceProdotto] = productElement;

            let product = `
                        <div class="card mb-3">
                            <div class="row g-0 align-items-center">
                                <div class="col-3 col-md-2 p-2">
                                    <img src="${products[i]["PercorsoImg"]}" 
                                        class="img-fluid rounded-start img-fixed" alt="Prodotto">
                                </div>
                                <div class="col-9 col-md-10">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <!-- Nome prodotto e quantità -->
                                            <div class="d-flex align-items-center flex-wrap">
                                                <h5 class="card-title mb-0 me-3">${nome}</h5>
                                                ${quantitaHTML}
                                            </div>

                                            <!-- Checkbox e prezzo -->
                                            <div class="d-flex align-items-center">
                                                <label style="display: none;" for="checkbox-${codiceProdotto}">Selezionato</label>
                                                <input type="checkbox" class="form-check-input me-2 product-checkbox"
                                                    id="checkbox-${codiceProdotto}"
                                                    onchange="aggiornaSelezionato(${codiceProdotto})"
                                                    ${checkbox}/>
                                                <p class="mb-0 fw-bold">
                                                    €${prezzo} 
                                                    <span id="moltiplicatore${codiceProdotto}">${quantita > 1 ? " x " + quantita : ""}</span>
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Bottoni -->
                                        <div class="mt-2 d-flex gap-2">
                                            <a href="singleProduct.php?id=${codiceProdotto}" 
                                            class="btn border border-dark btn-sm "><span class="bi bi-eye me-1"></span>Visualizza Articolo</a>
                                            <button class="btn btn-sm" style ="background-color:#B00000;color:#FFFFFF" 
                                                onclick="rimuoviDalCarrello(${codiceProdotto})"><span class="bi bi-trash3 me-1"></span>Rimuovi</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
            result += product;
        }
        result += `<div class="text-end fw-bold sticky-bottom bg-light py-2 border-top" id="tot"></div>`;
    }
    return result;
}

async function aggiornaCarrello() {
    try {
        const response = await fetch("Ajax/shoppingCart/api-shoppingCart.php");

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
        const response = await fetch("Ajax/shoppingCart/api-modifyCart.php", {
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
    if (nArticoli > 0) {
        const modalElement = document.getElementById('checkoutModal');
        const modal = new bootstrap.Modal(modalElement);
        const summary = document.getElementById('productSummary');
        let summaryHTML = "";
        productsFromId.forEach(product => {
            if (product["Selezionato"]) {
                quantita = product["Quantita"];
                summaryHTML += `<li class="list-group-item">${product["Nome"]}${quantita > 1 ? " x " + quantita : ""} - ${product["Prezzo"] * quantita} €</li>`;
            }
        });
        summary.innerHTML = summaryHTML;
        aggiornaSpedizione();
        modal.show();
    }
}

function validaDati() {
    const cardNumber = document.getElementById('cardNumber').value;
    const cardType = document.getElementById('cardType').value;
    const shippingType = document.getElementById('shippingType').value;
    if (shippingType == "") {
        alert('Selezionare tipo di spedizione.');
    } else if (cardType == "") {
        alert('Selezionare tipo di carta per il pagamento.');
    } else if (!/^[0-9]{16}$/.test(cardNumber)) {
        alert('Il numero della carta deve essere composto da 16 cifre.');
    } else {
        const modal = bootstrap.Modal.getInstance(document.getElementById('checkoutModal'));
        modal.hide();
        acquista();
    }
}

async function acquista() {
    data = { spedizione: spedizione };
    try {
        const response = await fetch("Ajax/shoppingCart/api-createOrder.php", {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });

        if (!response.ok) {
            throw new Error(`Errore nella richiesta: ${response.status}`);
        }
        const json = await response.json();
        modaleFinale(json.success);
    } catch (error) {
        modaleFinale(false);
    }
}

function modaleFinale(success) {
    let modal;
    if (success) {
        modal = new bootstrap.Modal(document.getElementById('orderSuccessModal'));
        aggiornaCarrello();
    } else {
        modal = new bootstrap.Modal(document.getElementById('orderErrorModal'));
    }
    modal.show();
}

aggiornaCarrello();
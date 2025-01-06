document.addEventListener("DOMContentLoaded", function () {
    fetchData('products');

    document.getElementById("viewProductsBtn").addEventListener("click", function () {
        fetchData('products');
    });

    document.getElementById("viewOrdersBtn").addEventListener("click", function () {
        fetchData('orders');
    });

    document.getElementById("viewStatsBtn").addEventListener("click", function () {
        fetchData('stats');
    });
});

async function fetchData(action) {
    const sendingData = { action: action };

    try {
        const response = await fetch('Ajax/api-seller.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(sendingData)
        });

        if (!response.ok) {
            throw new Error(`Errore nella richiesta: ${response.status}`);
        }

        const text = await response.text();
        console.log(text);

        const json = JSON.parse(text);
        console.log(json);

        if (json.success) {
            await updatePageContent(action, json.data)
        } else {
            if (action == "stats") {
                console.log(json.data);
            }
            document.getElementById('contentBody').innerHTML = '<p>Errore nel caricamento dei dati dal server.</p>';
            console.log(json.messaage);
        }
    } catch (error) {
        console.error('Errore nella richiesta AJAX:', error);
        document.getElementById('contentBody').innerHTML = '<p>Errore nella richiesta dati al server.</p>';
    }
}

async function updatePageContent(action, data) {
    const contentTitle = document.getElementById('contentTitle');
    const contentBody = document.getElementById('contentBody');

    switch (action) {
        case 'products':
            contentTitle.textContent = 'I tuoi Prodotti';
            contentBody.innerHTML = await generateProductList(data);
            addModalEventListener();
            data.forEach(product => {
                updateModalEventListeners(product);
            });
            break;
        case 'orders':
            contentTitle.textContent = 'Ordini richiesti';
            contentBody.innerHTML = generateOrderList(data);
            break;
        case 'stats':
            contentTitle.textContent = 'Le tue Statistiche';
            contentBody.innerHTML = generateStats(data);
            break;
        default:
            contentTitle.textContent = '';
            contentBody.innerHTML = '<p>Seleziona una sezione per visualizzare i dati.</p>';
            break;
    }
}

function getStars(rating) {
    let fullStars = '★'.repeat(Math.floor(rating));
    let emptyStars = '☆'.repeat(5 - Math.floor(rating));
    return fullStars + emptyStars;
}

async function generateProductList(products) {
    let html = ``;

    if (!products || products.length === 0) {
        html += '<p>Nessun prodotto aggiunto.</p>';
    }

    html += `<div id="contentBody" class = "row d-flex align-items-stretch">`;
    const modalhtml = await getAddModal();
    html += modalhtml;
    html += `<div class="col-md-4 col-6 p-2">
                <div class=" d-flex align-items-center justify-content-center shadow border p-4 h-100 bg-light rounded" 
                    style="cursor: pointer;" 
                    data-bs-toggle="modal" 
                    data-bs-target="#addProductModal">
                    <div class="text-center">
                        <i class="bi bi-plus-circle fs-1 mb-3"></i> 
                        <p class="fs-4 fw-semibold text-dark">Aggiungi Prodotto</p>
                    </div>
                </div>
            </div>`;



    products.forEach(product => {
        html += `
                <div class="col-md-4 col-6 p-2">
                    <div class="rounded shadow d-flex flex-column bg-light p-3 h-100 ${product["Disponibilita"] === 0 ? 'border-danger' : ''}">
                        <img src="${product["PercorsoImg"]}" alt="${product["Nome"]}" class="img-fluid position-relative">
                        <div class="d-flex flex-column align-items-center mt-auto">
                            <span class="fw-bold fs-3 mt-2">${product["Nome"]} </span>
                            <span class="text-success fs-5">${product["Prezzo"]}€</span>
                            <span class="fw-bold fs-5 mt-2 ${product["Disponibilita"] === 0 ? 'text-danger' : ''}">
                                Disponibilità: ${product["Disponibilita"]}
                            </span>
                            <div class="d-flex align-items-center">
                                <span class='text-warning fs-4'>${getStars(product["ValutazioneMedia"])}</span>
                                <span class='text-muted ms-1 small'>(${product["NumeroRecensioni"]})</span>
                            </div>
                            <div class="container mt-2">
                                <div class="d-flex align-items-center">
                                    <a href="singleProduct.php?id=${product['CodiceProdotto']}" class="btn border rounded btn-sm me-2 w-100">Visualizza</a>
                                    <a href="#" class="btn border rounded btn-sm w-100 ${product['Disponibilita'] === 0 ? 'text-danger border-danger' : ''}" data-bs-toggle="modal" data-bs-target="#updateAvailabilityModal-${product['CodiceProdotto']}">Rifornisci</a>
                                </div>
                                <div class="d-flex align-items-center mt-2">
                                    <a href="#" class="btn border rounded btn-sm me-2 w-100" data-bs-toggle="modal" data-bs-target="#deleteProductModal-${product['CodiceProdotto']}">Elimina</a>
                                    <a href="#" class="btn border rounded btn-sm w-100" data-bs-toggle="modal" data-bs-target="#updateProductModal-${product['CodiceProdotto']}">Modifica</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
        const updatemodalhtml = getUpdateModal(product);
        html += updatemodalhtml;
    });



    html += `</div>`

    return html;


}

function generateOrderList(orders) {
    if (!orders || orders.length === 0) return '<p>Nessun ordine trovato.</p>';

    let html = `<div id="orders-list">`;

    // Raggruppamento degli ordini per ID
    const groupedOrders = orders.reduce((acc, order) => {
        if (!acc[order.IDordine]) {
            acc[order.IDordine] = {
                IDordine: order.IDordine,
                Data: order.Data,
                Cliente: order.Cliente,
                PrezzoTotale: 0,
                Prodotti: []
            };
        }

        acc[order.IDordine].Prodotti.push({
            Nome: order.Nome,
            Quantita: order.Quantita,
            PrezzoPagato: order.PrezzoPagato,
            CodiceProdotto: order.CodiceProdotto,
            PercorsoImg: order.PercorsoImg
        });

        acc[order.IDordine].PrezzoTotale += parseFloat(order.PrezzoPagato);

        return acc;
    }, {});

    Object.values(groupedOrders).forEach(order => {
        html += `
        <!-- Single Order -->
        <div class="my-3 border rounded shadow">
            <!-- Order Info -->
            <div class="d-flex flex-column flex-md-row ms-3 justify-content-md-around ms-md-0 my-4">
                <span class="fs-5">ID Ordine: <span class="fw-semibold">${order.IDordine}</span></span>
                <span class="fs-5">Costo Totale: <span class="fw-semibold">${order.PrezzoTotale.toFixed(2)}</span>€</span>
                <span class="fs-5">Data Ordine: <span class="fw-semibold">${order.Data}</span></span>
            </div>
            <!-- Separator -->
            <hr class="mb-4">
            <!-- Product List -->
            <div class="px-4">`;

        order.Prodotti.forEach(product => {
            html += `
                <!-- Single Product -->
                <div class="row justify-content-center bg-light border rounded p-3 mb-3">
                    <div class="col-md-2 col-6">
                        <img src="${product.PercorsoImg}" alt="img" class="img-fluid">
                    </div>
                    <div class="col-md-10 col-12 flex-column ps-md-5">
                        <div>
                            <h2 class="fw-semibold fs-4">${product.Nome}</h2>
                            <span class="fs-5 me-4">Quantità: ${product.Quantita}</span>
                            <span class="fs-5 text-muted">${product.PrezzoPagato.toFixed(2)} €</span>
                        </div>
                        <div class="mt-4">
                            <a href="singleProduct.php?id=${product.CodiceProdotto}" class="btn btn-primary btn-sm">Visualizza articolo</a>
                        </div>
                    </div>
                </div>`;
        });

        html += `
            </div>
            <!-- Button -->
            <div class="d-flex justify-content-md-end justify-content-center p-3">
                <button type="button" class="btn btn-light btn-lg">Spedisci</button>
            </div>
        </div>`;
    });

    html += `</div>`;
    return html;
}




function generateStats(stats) {
    if (!stats) return '<p>Nessun statistica trovato.</p>';
    /*if (!stats || typeof stats !== 'object') {
        return '<p>Errore nel recupero delle statistiche.</p>';
    }

    let errorMessages = [];

    // Verifica ciascun campo delle statistiche
    if (stats.totalSales && stats.totalSales.success === false) {
        errorMessages.push('Errore nel recupero delle vendite totali: ' + stats.totalSales.message);
    }
    if (stats.topSellingProducts && stats.topSellingProducts.success === false) {
        errorMessages.push('Errore nel recupero dei prodotti più venduti: ' + stats.topSellingProducts.message);
    }
    if (stats.reviews && stats.reviews.success === false) {
        errorMessages.push('Errore nel recupero delle recensioni: ' + stats.reviews.message);
    }
    if (stats.conversionRate && stats.conversionRate.success === false) {
        errorMessages.push('Errore nel recupero del tasso di conversione: ' + stats.conversionRate.message);
    }
    if (stats.delayedShipments && stats.delayedShipments.success === false) {
        errorMessages.push('Errore nel recupero delle spedizioni ritardate: ' + stats.delayedShipments.message);
    }

    // Se ci sono errori, restituisci un messaggio di errore con tutti i dettagli
    if (errorMessages.length > 0) {
        return '<p>' + errorMessages.join('</p><p>') + '</p>';
    }*/

    let html = `
        <div class="row">
            <!-- Guadagno Totale -->
            <div class="col-md-4">
                <div class="card shadow p-3 mb-4">
                    <h5 class="card-title">Vendite Totali</h5>
                    <p class="fs-3">${stats.totalSales}€</p>
                    <p>Vendite totali nel periodo selezionato</p>
                </div>
            </div>
            <!-- Prodotti Più Venduti -->
            <div class="col-md-4">
                <div class="card shadow-lg rounded-3 p-4 mb-4">
                    <h5 class="card-title text-center text-uppercase text-success">Prodotti Più Venduti</h5>
                    <ul class="list-unstyled">
                        ${stats.topSellingProducts.length > 0 ? stats.topSellingProducts.map(product => `
                            <li class="d-flex justify-content-between">
                                <img src="${product.PercorsoImg}" alt="img prodotto" class="img-fluid">
                                <span>${product.Nome}</span>
                                <span class="badge ">${product.quantita} venduti</span>
                                <a href="singleProduct.php?id=${product.CodiceProdotto}" class="btn btn-primary btn-sm">Visualizza articolo</a>
                            </li>
                        `).join('') : '<li><span>Nessun prodotto venduto nel periodo selezionato</span></li>'}
                    </ul>
                </div>
            </div>
        </div>
        
    `;

    return html;
}

document.addEventListener("DOMContentLoaded", function () {
    fetchData('products');

    document.getElementById("viewProductsBtn").addEventListener("click", function () {
        const pageType = document.getElementById('contentTitle').dataset.type;
        console.log(pageType);
        if (pageType != "products") {
            fetchData('products');
        } else {
            console.log('gia nella pagina selezionata');
        }
    });

    document.getElementById("viewOrdersBtn").addEventListener("click", function () {
        const pageType = document.getElementById('contentTitle').dataset.type;
        if (pageType != "orders") {
            fetchData('orders');
        } else {
            console.log('gia nella pagina selezionata');
        }
    });

    document.getElementById("viewStatsBtn").addEventListener("click", function () {
        const pageType = document.getElementById('contentTitle').dataset.type;
        if (pageType != "stats") {
            fetchData('stats');
        } else {
            console.log('gia nella pagina selezionata');
        }
    });

    document.getElementById("viewReviewsBtn").addEventListener("click", function () {
        const pageType = document.getElementById('contentTitle').dataset.type;
        if (pageType != "reviews") {
            fetchData('reviews');
        } else {
            console.log('gia nella pagina selezionata');
        }
    });
});

async function fetchData(action) {
    sendingData = {};
    if (action == "stats" && document.getElementById('timeRange')) {
        sendingData = {
            action: action,
            periodo: document.getElementById('timeRange').value
        };
    } else {
        sendingData = {
            action: action
        };
    }


    try {
        const response = await fetch('Ajax/seller/api-seller.php', {
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
            document.getElementById('contentBody').innerHTML = '<p>Errore nel caricamento dei dati dal server.</p>';
        }
    } catch (error) {
        console.error('Errore nella richiesta AJAX:', error);
        document.getElementById('contentBody').innerHTML = '<p>Errore nella richiesta dati al server.</p>';
    }
}

async function updatePageContent(action, data) {
    const contentBody = document.getElementById('contentBody');

    let pageType;

    switch (action) {
        case 'products':
            pageType = "products";
            contentBody.innerHTML = await generateProductList(data);
            addModalEventListener();
            data["products"].forEach(product => {
                updateModalEventListeners(product);
            });
            break;
        case 'orders':
            pageType = "orders";
            const groupedOrders = getGroupedOrders(data);
            contentBody.innerHTML = generateOrderList(groupedOrders);
            Object.values(groupedOrders).forEach(order => {
                sendOrderEventListeners(order);
            });
            break;
        case 'stats':
            pageType = "stats";
            contentBody.innerHTML = generateStats(data);
            document.getElementById('timeRange').value = data["periodo"];
            statsListener();
            break;
        case 'reviews':
            pageType = "reviews";
            contentBody.innerHTML = generateReviews(data);
            break;
        default:
            pageType = "default";
            contentBody.innerHTML = "<p>No content available.</p>";
    }

    const contentTitle = document.getElementById('contentTitle');
    contentTitle.dataset.type = pageType;
}


function getStars(rating) {
    let fullStars = '★'.repeat(Math.floor(rating));
    let emptyStars = '☆'.repeat(5 - Math.floor(rating));
    return fullStars + emptyStars;
}

async function generateProductList(data) {
    let html = ``;
    const products = data["products"];
    const number = data["productNumber"];


    if (!products || products.length === 0) {
        html += '<p>Nessun prodotto aggiunto.</p>';
    }
    let contentTitle = document.getElementById('contentTitle');
    contentTitle.textContent = `I tuoi Prodotti (${number})`;

    html += `<div id="contentBody" class = "row d-flex align-items-stretch">`;
    const modalhtml = await getAddModal();
    html += modalhtml;
    html += `<div class="col-md-4 col-6 p-2">
                <div class=" d-flex align-items-center justify-content-center shadow border p-4 h-100 rounded" 
                    style="cursor: pointer;" 
                    data-bs-toggle="modal" 
                    data-bs-target="#addProductModal">
                    <div class="text-center">
                        <span class="bi bi-plus-circle fs-1 mb-3"></span> 
                        <p class="fs-4 fw-semibold text-dark">Aggiungi Prodotto</p>
                    </div>
                </div>
            </div>`;



    products.forEach(product => {
        html += `
                <div class="col-md-4 col-6 p-2">
                    <div class="rounded shadow d-flex flex-column p-3 h-100 ${product["Disponibilita"] === 0 ? 'border-danger' : ''}">
                        <img src="${product["PercorsoImg"]}" alt="${product["Nome"]}" class="img-fluid position-relative">
                        <div class="d-flex flex-column align-items-center mt-auto">
                            <span class="fw-bold fs-3 mt-2 text-center">${product["Nome"]} </span>
                            <span class="fs-5">${product["Prezzo"]}€</span>
                            <span class="fw-bold fs-5 mt-2" style="${product["Disponibilita"] === 0 ? 'color:#B00000' : ''}" id="productAvailability-${product["CodiceProdotto"]}" data-availability="${product["Disponibilita"]}">
                                Disponibilità: ${product["Disponibilita"]}
                            </span>
                            <div class="d-flex align-items-center">
                                <span class='text-warning fs-4'>${getStars(product["ValutazioneMedia"])}</span>
                                <span class='text-muted ms-1 small'>(${product["NumeroRecensioni"]})</span>
                            </div>
                            <div class="d-flex flex-column mt-2">
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-2">
                                        <a href="singleProduct.php?id=${product['CodiceProdotto']}" class="btn border rounded btn-sm w-100">Visualizza</a>
                                    </div>
                                    <div class="col-12 col-md-6 mb-2">
                                        <a href="#" class="btn border rounded btn-sm w-100 " style="${product['Disponibilita'] === 0 ? 'color:#B00000' : ''}" data-bs-toggle="modal" data-bs-target="#updateAvailabilityModal-${product['CodiceProdotto']}">Rifornisci</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-2">
                                        <a href="#" class="btn border rounded btn-sm w-100" data-bs-toggle="modal" data-bs-target="#updateProductModal-${product['CodiceProdotto']}">Cambia €</a>
                                    </div>
                                    <div class="col-12 col-md-6 mb-2">
                                        <a href="#" class="btn border rounded btn-sm w-100" style="color:#B00000" data-bs-toggle="modal" data-bs-target="#deleteProductModal-${product['CodiceProdotto']}">Elimina</a>
                                    </div>
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

function generateOrderList(groupedOrders) {
    if (!groupedOrders || groupedOrders.length === 0) return '<p>Nessun ordine trovato.</p>';

    const number = Object.keys(groupedOrders).length;
    let contentTitle = document.getElementById('contentTitle');
    contentTitle.textContent = `Ordini in Arrivo (${number})`;

    let html = `<div id="orders-list">`;

    Object.values(groupedOrders).forEach(order => {
        html += `
        <!-- Single Order -->
        <div class="my-3 card shadow">
            <!-- Order Info -->
            <div class="d-flex flex-column flex-md-row ms-3 justify-content-md-around ms-md-0 my-4">
                <span class="fs-5">ID Ordine: <span class="fw-semibold">${order.IDordine}</span></span>
                <span class="fs-5">Costo Totale: <span class="fw-semibold">${order.PrezzoTotale}</span>€</span>
                <span class="fs-5">Data Ordine: <span class="fw-semibold">${order.Data}</span></span>
            </div>
            <!-- Separator -->
            <hr class="mb-4">
            <!-- Product List -->
            <div class="px-4">`;

        order.Prodotti.forEach(product => {
            html += `
                <!-- Single Product -->
                <div class="row justify-content-center align-items-center border rounded shadow-sm p-3 mb-3">
                    <div class="col-md-2 col-6">
                        <img src="${product.PercorsoImg}" alt="img" class="img-fluid">
                    </div>
                    <div class="col-md-10 col-12 flex-column ps-md-5">
                        <div>
                            <h2 class="fw-semibold fs-4">${product.Nome}</h2>
                            ${product.Rimosso === 'Y' ? '<h2 class="fw-semibold fs-4">(Prodotto Rimosso)</h2>' : ''}
                            <span class="fs-5 me-4">Quantità: ${product.Quantita}</span>
                            <span class="fs-5 text-muted">${product.PrezzoPagato} €</span>
                        </div>
                        <div class="mt-4">
                            <a href="singleProduct.php?id=${product.CodiceProdotto}" class="btn border-dark">Visualizza articolo</a>
                        </div>
                    </div>
                </div>`;
        });

        html += `
            </div>
            <!-- Button -->
            <div class="d-flex justify-content-md-end justify-content-center  p-3">
                <button type="button" class="btn btn-lg" id="sendOrder-${order.IDordine}" style = "background-color:#000060;color:#FFFFFF">Spedisci</button>
            </div>
        </div>`;
    });

    html += `</div>`;
    return html;
}
function getGroupedOrders(orders) {
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
            PercorsoImg: order.PercorsoImg,
            Rimosso: order.Rimosso
        });

        acc[order.IDordine].PrezzoTotale += parseFloat(order.PrezzoPagato);

        return acc;
    }, {});
    return groupedOrders;
}

function generateStats(stats) {
    if (!stats) return '<p>Nessun statistica trovato.</p>';

    let contentTitle = document.getElementById('contentTitle');
    contentTitle.textContent = `Le tue Statistiche`;

    let html = `
    <div class = "row my-4">
        <div class = "col-md-4">
            <div class="form-group">
            <label for="timeRange" style="display:none"class="form-label">Seleziona l'intervallo di tempo:</label>
                <div class="input-group">
                    <select id="timeRange" class="form-select">
                        <option value="all">Di sempre</option>
                        <option value="week">Ultima settimana</option>
                        <option value="month">Ultimo mese</option>
                        <option value="year">Ultimo anno</option>
                    </select>
                    <button class="btn ms-2" style="background-color:#000060;color:#FFFFFF" type="button" id="submitBtn">Invia</button>
                </div>
            </div>
        </div >
    </div >`


    html += `
        <div class="row row-cols-2 row-cols-md-3 g-4 mt-3">
            <!-- Prodotti Venduti Totale -->
            <div class="col">
                <div class="card shadow h-100 p-3">
                    <p class = "fs-4" class="card-title">Prodotti Distinti Venduti</p>
                    <p class="fs-3">${stats.totalSelledProduct}</p>
                </div>
            </div>
            <!-- Quantità Venduta Totale -->
            <div class="col">
                <div class="card shadow h-100 p-3">
                    <p class = "fs-4" class="card-title">Quantità Totale Venduta</p>
                    <p class="fs-3">${stats.totalSelledQuantity}</p>
                </div>
            </div>
            <!-- Guadagno Totale -->
            <div class="col">
                <div class="card shadow h-100 p-3">
                    <p class = "fs-4" class="card-title">Guadagno Totale</p>
                    <p class="fs-3">${stats.totalSales}€</p>
                </div>
            </div>
            <!-- Like Totali -->
            <div class="col">
                <div class="card shadow h-100 p-3">
                    <p class = "fs-4" class="card-title">Mi Piace Totali</p>
                    <p class="fs-3">${stats.totalLikeReceived}</p>
                </div>
            </div>
            <!-- Recensioni Prodotti -->
            <div class="col">
                <div class="card shadow h-100 p-3">
                    <p class = "fs-4" class="card-title">Recensioni Totali</p>
                    <p class="fs-3">${stats.reviewsData["totalReviews"]}</p>
                </div>
            </div>
            <!-- Valutazione Media -->
            <div class="col">
                <div class="card shadow h-100 p-3">
                    <p class = "fs-4" class="card-title">Valutazione Media</p>
                    <span class="fs-3 text-warning">
                        ${getStars(stats.reviewsData["averageRating"])} 
                        <span class="fs-3 text-dark">${stats.reviewsData["averageRating"].slice(0, 3)}</span>
                    </span>
                </div>
            </div>
        </div>`

    html += `
        <!-- Prodotti Più Venduti -->
        <div class="row ">
            <div class = "col-md-12 ">
                <div class = "card shadow my-3 p-3">
                    <!-- Title-->
                    <h2 class="card-title mt-3">Prodotti Più Venduti</h2> 
                    
                    <!-- Separator -->
                    <hr class="mb-4">

                    <!-- Product List -->
                    <div class="px-3">
                        <!-- Single Product -->
                        ${stats.topSellingProducts.length > 0 ? stats.topSellingProducts.map(product => `
                        <div class="row justify-content-center justify-content-md-start align-items-center border rounded shadow-sm p-3 mb-3">
                            <div class="col-md-2 col-6  ">
                                <img src="${product.PercorsoImg}" alt="img" class="img-fluid">
                            </div>
                            <div class="col-md-8 col-12 align-content-center flex-column ps-md-5 ">
                                <h2 class="fw-semibold fs-4">${product.Nome}</h2>
                                ${product.Rimosso == 'Y' ? '<h2 class="fw-semibold fs-4">(Prodotto Rimosso)</h2>' : ''}
                                <span class="fs-5 me-4">Quantità totale venduta: ${product.Quantita}</span>
                                <p class="fs-5 me-4">Ricavo totale: ${product.RicavoTotale} €</p>
                                <a href="singleProduct.php?id=${product.CodiceProdotto}" class="btn"style="background-color:#000060;color:#FFFFFF">Visualizza articolo</a>
                            </div>
                        </div>`).join('') : '<li><span>Nessun prodotto venduto nel periodo selezionato</span></li>'}
                    </div>
                </div>
            </div>
        </div>`;

    html += `
        <!-- Prodotti con piu like -->
        <div class="row ">
            <div class = "col-md-12 ">
                <div class = "card shadow my-3 p-3">
                    <!-- Title-->
                    <h2 class="card-title mt-3">Prodotti Più Piaciuti</h2> 
                    
                    <!-- Separator -->
                    <hr class="mb-4">

                    <!-- Product List -->
                    <div class="px-3">
                        <!-- Single Product -->
                        ${stats.topLikedProducts.length > 0 ? stats.topLikedProducts.map(product => `
                        <div class="row justify-content-center justify-content-md-start align-items-center border rounded shadow-sm p-3 mb-3">
                            <div class="col-md-2 col-6  ">
                                <img src="${product.PercorsoImg}" alt="img" class="img-fluid">
                            </div>
                            <div class="col-md-8 col-12 align-content-center flex-column ps-md-5 ">
                                <h2 class="fw-semibold fs-4">${product.Nome}</h2>
                                ${product.Rimosso == 'Y' ? '<h2 class="fw-semibold fs-4">(Prodotto Rimosso)</h2>' : ''}
                                <p class="fs-5 me-4"> Mi piace totali: ${product.likeTotali}</p>
                                <a href="singleProduct.php?id=${product.CodiceProdotto}" class="btn"style="background-color:#000060;color:#FFFFFF">Visualizza articolo</a>
                            </div>
                        </div>`).join('') : '<li><span>Nessun prodotto venduto nel periodo selezionato</span></li>'}
                    </div>
                </div>
            </div>
        </div>`;

    return html;
}

function statsListener() {
    document.getElementById('submitBtn').addEventListener('click', function () {
        fetchData("stats");
    });
}



function generateReviews(data) {
    if (!data || !data.reviews || data.reviews.length === 0) {
        return '<p>Nessuna recensione trovata.</p>';
    }

    let contentTitle = document.getElementById('contentTitle');
    contentTitle.textContent = `Le tue Recensioni (${data.reviews.length})`;

    let reviews = data.reviews;
    let html = ``;

    let groupedReviews = reviews.reduce((acc, review) => {
        if (!acc[review.CodiceProdotto]) {
            acc[review.CodiceProdotto] = {
                CodiceProdotto: review.CodiceProdotto,
                Nome: review.Nome,
                PercorsoImg: review.PercorsoImg,
                Rimosso: review.Rimosso,
                Recensioni: []
            };
        }
        acc[review.CodiceProdotto].Recensioni.push({
            IDrecensione: review.IDrecensione,
            Cliente: review.Cliente,
            Stelle: review.Stelle,
            Testo: review.Testo
        });

        return acc;
    }, {});


    Object.values(groupedReviews).forEach(product => {
        html += `
        <div class="card shadow mt-5 p-3">
            <!-- Product Info -->
            <div class="row d-flex align-items-center">
                <div class="col-md-2 col-12">
                    <img src="${product.PercorsoImg}" alt="img" class="img-fluid">
                </div>
                <div class="col-md-6 col-12">
                    <div class = "d-flex flex-column align-items-center align-items-md-start">
                        <h3 class="fw-semibold">${product.Nome}</h3>
                        ${product.Rimosso == 'Y' ? '<h4 class="fw-semibold fs-4">(Prodotto Rimosso)</h4>' : ''}
                        <span class = "fs-5">Codice Prodotto: <span class = "fw-semibold">${product.CodiceProdotto}</span></span>
                        <div class="mt-4">
                            <a href="singleProduct.php?id=${product.CodiceProdotto}" class="btn"style="background-color:#000060;color:#FFFFFF">Visualizza articolo</a>
                        </div>
                    </div>
                </div>
            </div>

            <!--Separator-->
            <hr class="mb-4">
            
            <!-- Reviews for the product -->
            <div class="px-4">`;

        product.Recensioni.forEach(review => {
            html += `
            <div class="card my-4 p-3 shadow-sm">
                <!-- Review Info -->
                <div class="row align-items-center">
                    <div class="col-12">
                        <div class = "d-flex flex-column flex-md-row" >
                            <span class="fs-5">ID Recensione: <span class = "fw-semibold">${review.IDrecensione}</span></span>
                            <span class="fs-5 mx-md-5 ">Cliente: <span class = "fw-semibold">${review.Cliente}</span></span>
                            <span class="fs-5 me-4 text-warning">${getStars(review.Stelle)} <span class="fs-5 text-dark ">(${review.Stelle})</span></span>
                        </div>
                        <hr>
                        <div class="card-body">
                            <h4> Descrizione: </h4>
                            <span class = "mt-3">${review.Testo}<span>
                        </div>
                    </div>
                </div>
            </div>`;
        });

        html += `</div> <!-- Fine recensioni per prodotto -->
        </div>`;
    });

    return html;
}



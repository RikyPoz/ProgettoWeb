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

        const json = await response.json();

        if (json.success) {
            console.log(json.data);
            updatePageContent(action, json.data)
        } else {
            document.getElementById('contentBody').innerHTML = '<p>Errore nel caricamento dei dati dal server.</p>';
            console.log(json.messaage);
        }
    } catch (error) {
        console.error('Errore nella richiesta AJAX:', error);
        document.getElementById('contentBody').innerHTML = '<p>Errore nella richiesta dati al server.</p>';
    }
}

function updatePageContent(action, data) {
    const contentTitle = document.getElementById('contentTitle');
    const contentBody = document.getElementById('contentBody');

    switch (action) {
        case 'products':
            contentTitle.textContent = 'I tuoi Prodotti';
            contentBody.innerHTML = generateProductList(data);
            break;
        case 'orders':
            contentTitle.textContent = 'I tuoi Ordini';
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

function generateProductList(products) {
    let html = ``;

    if (!products || products.length === 0) {
        html += '<p>Nessun prodotto aggiunto.</p>';
    }

    html += `
    <div id="contentBody" class = "row d-flex align-items-stretch">
        <div class="col-md-4 col-6 p-2 ">
            <div class="card d-flex align-items-center justify-content-center shadow border p-4 h-100 bg-light rounded">
                <div class="text-center">
                    <i class="bi bi-plus-circle fs-1 mb-3"></i> <!-- Icona "+" -->
                    <p class="fs-4 fw-semibold text-dark">Aggiungi Prodotto</p>
                </div>
            </div>
        </div>`


    products.forEach(product => {
        html += `
        <div class = "col-md-4 col-6 p-2">
            <div class=" rounded shadow d-flex flex-column bg-light p-3 h-100">
                <img src="${product["PercorsoImg"]}" alt="${product["Nome"]}" class="img-fluid"> 
                <div class = "d-flex flex-column align-items-center mt-auto">
                    <span class="fw-bold fs-4 mt-2">${product["Nome"]} </span>
                    <span class="text-success fs-5">${product["Prezzo"]}€</span>
                    <div class = "d-flex align-items-center">
                        <span class='text-warning fs-4'>${getStars(product["ValutazioneMedia"])}</span>
                        <span class='text-muted ms-1 small'>(${product["NumeroRecensioni"]})</span>
                    </div>
                    <div class = "d-flex align-items-center">
                        <a href="singleProduct.php?id=${product["CodiceProdotto"]}" class="btn border rounded border-dark btn-sm mt-2">Visualizza articolo</a>
                        <a href="singleProduct.php?id=${product["CodiceProdotto"]}" class="btn border rounded border-dark btn-sm mt-2 ms-2">Modifica articolo</a>
                    </div>
                </div>
            </div>
        </div>`;
    });

    html += `</div>`

    return html;


}

function generateOrderList(orders) {
    if (!orders || orders.length === 0) return '<p>Nessun ordine trovato.</p>';

    let html = '';
    return html;
}

function generateStats(stats) {
    if (!stats) return '<p>Errore nel recupero delle statistiche.</p>';

    let html = '';
    return html;
}

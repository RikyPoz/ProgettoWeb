
let selectedMinPrice = 0;
let selectedMaxPrice = 10000;
let minPrice = 0;
let maxPrice = 10000;

const minPriceInput = document.getElementById('minPriceInput'); 
const maxPriceInput = document.getElementById('maxPriceInput');
const displayedMinPrice = document.getElementById('displayMinPrice');
const displayedMaxPrice = document.getElementById('displayMaxPrice');
const filterType = document.getElementById("filterType").getAttribute("data");
const filterValue = document.getElementById("filterType").textContent;

function mapQuadratic(value) {
    const normalized = value / 100;
    return minPrice + normalized ** 2 * (maxPrice - minPrice);
}

function updatePriceRange() {
    if (parseFloat(minPriceInput.value) > parseFloat(maxPriceInput.value)) {
      minPriceInput.value = maxPriceInput.value;
    }
    selectedMinPrice = mapQuadratic(parseFloat(minPriceInput.value)).toFixed(2);
    selectedMaxPrice = mapQuadratic(parseFloat(maxPriceInput.value)).toFixed(2);

    displayedMinPrice.textContent = `€${selectedMinPrice}`;
    displayedMaxPrice.textContent = `€${selectedMaxPrice}`;
}

async function getPriceMinMax() {
    const data = {
        type: filterType,
        value: filterValue
    };
    try {
        const response = await fetch("Ajax/api-prices.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(data)
        });

        if (!response.ok) {
            throw new Error(`Errore nella richiesta: ${response.status}`);
        }
        const json = await response.json();
        console.log(json);
        minPrice = json[0]["min"];
        maxPrice = json[0]["max"];
        updatePriceRange();
        
    } catch (error) {
        console.log("Errore durante il caricamento degli estremi dei prezzi:", error.message);
    }
}

function addProductsLink() {
    const productCards = document.querySelectorAll(".product-card");
    productCards.forEach(card => {
        card.addEventListener("click", function () {
            const productId = this.getAttribute("data-id");
            if (productId) {
                window.location.href = `singleProduct.php?id=${productId}`;
            }
        });
    });   
}

function getProductList(products) {
    let result = "";

    for(let i=0; i < products.length; i++){
        let product = `
            <div class='col-6 col-md-4 col-lg-3'>
                <div class='card text-center shadow-sm border-0 product-card' data-id='${products[i]["CodiceProdotto"]}' style='cursor: pointer;'>
                    <img src='${products[i]["PercorsoImg"]}' class='card-img-top rounded-3' alt='Prodotto'>
                    <div class='card-body'>
                        <h6 class='card-title text-dark fw-semibold'>${products[i]["Nome"]}</h6>
                        <p class='text-success fw-bold'>€${products[i]["Prezzo"].toFixed(2)}</p>
                        <div class='d-flex justify-content-center align-items-center'>
                            <span class='text-warning fs-4'>${products[i]["ValutazioneMedia"]}</span>
                            <span class='text-muted ms-1 small'>(${products[i]["NumeroRecensioni"]})</span>
                        </div>
                    </div>
                </div>
            </div>`;
        result += product;
    }
    return result;
}

async function updateProductList() {
    // Raccolta dei valori dei checkbox colore
    const selectedColors = Array.from(document.querySelectorAll('[data-group="colore"] .form-check-input:checked'))
        .map(input => input.id);

    // Raccolta dei valori dei checkbox "Recensioni"
    const selectedStars = Array.from(document.querySelectorAll("#fiveStars:checked, #fourStars:checked, #threeStars:checked"))
        .map(input => input.id);

    const filters = {
        NomeColore: selectedColors,
        Prezzo: { min: selectedMinPrice, max: selectedMaxPrice },
        [filterType]: filterValue,
        ValutazioneMedia: { min: selectedStars.includes("threeStars") ? 3 :
                        selectedStars.includes("fourStars") ? 4 :
                        selectedStars.includes("fiveStars") ? 5 : 0, max: 5 }
    };
    try {
        const response = await fetch("Ajax/api-filterProducts.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(filters)
        });

        if (!response.ok) {
            throw new Error(`Errore nella richiesta: ${response.status}`);
        }
        const json = await response.json();
        document.getElementById("productCount").textContent = ` (${json.length})`;
        const productsContainer = document.getElementById("productsContainer");
        productsContainer.innerHTML = getProductList(json);
        addProductsLink();
        
    } catch (error) {
        console.log("Errore durante il caricamento dei prodotti filtrati:", error.message);
    }
}


document.getElementById("filterButton").addEventListener("click", updateProductList);
minPriceInput.addEventListener('input', updatePriceRange);
maxPriceInput.addEventListener('input', updatePriceRange);
getPriceMinMax();
updateProductList();
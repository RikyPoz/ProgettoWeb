function getProductList(products) {
    let result = "";

    for(let i=0; i < products.length; i++){
        let product = `
            <div class='col-6 col-md-4 col-lg-3'>
                <div class='card text-center shadow-sm border-0'>
                    <img src='${products[i]["PercorsoImg"]}' class='card-img-top rounded-3' alt='Prodotto'>
                    <div class='card-body'>
                        <h6 class='card-title text-dark fw-semibold'>${products[i]["Nome"]}</h6>
                        <p class='text-success fw-bold'>€${products[i]["Prezzo"].toFixed(2)}</p>
                        <div class='d-flex justify-content-center align-items-center'>
                            <span class='text-warning fs-4'>${getStars(products[i]["ValutazioneMedia"])}</span>
                            <span class='text-muted ms-1 small'>(${products[i]["NumeroRecensioni"]})</span>
                        </div>
                    </div>
                </div>
            </div>`;
        result += product;
    }
    return result;
}




document.querySelector(".btn-success").addEventListener("click", function () {
// Raccolta dei valori dei checkbox "Colore"
const selectedColors = Array.from(document.querySelectorAll(".form-check-input[type='checkbox']:checked"))
    .map(input => input.id);

// Raccolta dei valori dello slider prezzo
const minPrice = document.getElementById("minPrice").value;
const maxPrice = document.getElementById("maxPrice").value;

// Raccolta dei valori dei checkbox "Recensioni"
const selectedStars = Array.from(document.querySelectorAll("#fiveStars:checked, #fourStars:checked, #threeStars:checked"))
    .map(input => input.id);

// Creazione dell'oggetto filtri
const filters = {
    Colore: selectedColors,
    Prezzo: { min: minPrice, max: maxPrice },
    ValutazioneMedia: selectedStars.includes("fiveStars") ? 5 :
                    selectedStars.includes("fourStars") ? 4 :
                    selectedStars.includes("threeStars") ? 3 : null
};

// Invio dei dati al server tramite fetch
fetch("FilteredProducts.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(filters)
})
    .then(response => response.json())
    .then(products => {
        // Aggiornamento dinamico della lista dei prodotti
        const productsContainer = document.querySelector(".row.g-4");
        productsContainer.innerHTML = "";

        products.forEach(product => {
            const productHTML = `
                <div class='col-6 col-md-4 col-lg-3'>
                    <div class='card text-center shadow-sm border-0'>
                        <img src='${product.PercorsoImg}' class='card-img-top rounded-3' alt='Prodotto'>
                        <div class='card-body'>
                            <h6 class='card-title text-dark fw-semibold'>${product.Nome}</h6>
                            <p class='text-success fw-bold'>€${Number(product.Prezzo).toFixed(2)}</p>
                            <div class='d-flex justify-content-center align-items-center'>
                                <span class='text-warning fs-4'>${getStars(product.ValutazioneMedia)}</span>
                                <span class='text-muted ms-1 small'>(${product.NumeroRecensioni})</span>
                            </div>
                        </div>
                    </div>
                </div>`;
                productsContainer.insertAdjacentHTML("beforeend", productHTML);
        });
    })
    .catch(error => console.error("Errore durante il caricamento dei prodotti filtrati:", error));
});

// Funzione per generare stelle (modifica se necessario)
function getStars(rating) {
    let stars = "";
    for (let i = 0; i < Math.floor(rating); i++) stars += "★";
    for (let i = Math.floor(rating); i < 5; i++) stars += "☆";
    return stars;
}



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



document.getElementById("filterButton").addEventListener("click", async function () {
    console.log("funzione");
    // Raccolta dei valori dei checkbox colore
    const selectedColors = Array.from(document.querySelectorAll('[data-group="colore"] .form-check-input:checked'))
        .map(input => input.id);
    // Raccolta dei valori dello slider prezzo
    const minPrice = document.getElementById("selectedMinPrice").value;
    const maxPrice = document.getElementById("selectedMaxPrice").value;

    // Raccolta dei valori dei checkbox "Recensioni"
    const selectedStars = Array.from(document.querySelectorAll("#fiveStars:checked, #fourStars:checked, #threeStars:checked"))
        .map(input => input.id);

    const filters = {
        Colore: selectedColors,
        Prezzo: { min: minPrice, max: maxPrice },
        ValutazioneMedia: selectedStars.includes("fiveStars") ? 5 :
                        selectedStars.includes("fourStars") ? 4 :
                        selectedStars.includes("threeStars") ? 3 : null
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
        console.log(json);
        const productsContainer = document.getElementById("productsContainer");
        productsContainer.innerHTML = getProductList(json);
        
    } catch (error) {
        console.log("Errore durante il caricamento dei prodotti filtrati:", error.message);
    }
});

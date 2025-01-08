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
                <span>${prices["spedizione"]}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between fw-bold">
                <span>Totale</span> 
                <span>€${prices["tot"]}</span>
            </li>`
}

async function aggiornaRiepilogo() {
    const selectedProducts = {};
    document.querySelectorAll('.product-checkbox:checked').forEach((checkbox) => {
        const id = checkbox.getAttribute('data-id');
        selectedProducts[id] = document.getElementById(id).value;
    });
    try {
        const response = await fetch("Ajax/api-shoppingCart.php", {
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
        recapTable.innerHTML = getResoconto(json);
        
    } catch (error) {
        console.log("Errore durante il caricamento del riepilogo carrello:", error.message);
    }
}
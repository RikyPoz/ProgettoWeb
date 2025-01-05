async function attachEventListenersToModal() {
    const saveProductBtn = document.getElementById("saveProductBtn");

    saveProductBtn.addEventListener("click", async function () {
        const nome = document.getElementById("productName").value.trim();
        const prezzo = document.getElementById("productPrice").value.trim();
        const descrizione = document.getElementById("productDescription").value.trim();
        const immagine = document.getElementById("productImage").files[0];
        const materiale = document.getElementById("productMaterial").value.trim();
        const colore = document.getElementById("productColor").value.trim();
        const ambiente = document.getElementById("productEnvironment").value.trim();
        const categoria = document.getElementById("productCategory").value.trim();
        const altezza = document.getElementById("productHeight").value.trim();
        const larghezza = document.getElementById("productWidth").value.trim();
        const profondita = document.getElementById("productDepth").value.trim();

        if (!nome || !prezzo || !descrizione || !immagine || !materiale || !colore || !ambiente || !categoria || !altezza || !larghezza || !profondita) {
            alert("Compila tutti i campi prima di salvare il prodotto.");
            return;
        }

        const sendingData = {
            action: "addProduct",
            nome: nome,
            prezzo: prezzo,
            descrizione: descrizione,
            percorsoImg: immagine,
            larghezza: larghezza,
            altezza: altezza,
            profondita: profondita,
            ambiente: ambiente,
            categoria: categoria,
            colore: colore,
            materiale: materiale,

        };
        try {
            const response = await fetch("Ajax/api-seller-product.php", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(sendingData)
            });

            if (!response.ok) {
                throw new Error(`Errore nella richiesta: ${response.status}`);
            }

            const result = await response.json();

            if (result.success) {
                alert("Prodotto aggiunto con successo!");
                fetchData("products"); //Per aggiornare la pagina html con il nuovo prodotto
                document.getElementById("addProductModalClose").click();
            } else {
                alert("Errore durante l'aggiunta del prodotto: " + result.message);
            }
        } catch (error) {
            console.error("Errore durante l'invio dei dati:", error);
            alert("Errore durante l'aggiunta del prodotto. Riprova.");
        }
    });
}

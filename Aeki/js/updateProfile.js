document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("modificaProfiloForm");

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(form);
        const data = {
            nome: formData.get('nome') || "",
            cognome: formData.get('cognome') || "",
            email: formData.get('email') || "",
            telefono: formData.get('telefono') || ""
        };

        // Validazione dei dati inseriti
        if (!data.nome.match(/^[a-zA-Z\s]+$/)) {
            alert("Il nome può contenere solo lettere.");
            return;
        }
        if (!data.cognome.match(/^[a-zA-Z\s]+$/)) {
            alert("Il cognome può contenere solo lettere.");
            return;
        }
        if (!data.email.includes("@")) {
            alert("Inserisci un'email valida.");
            return;
        }
        if (!data.telefono.match(/^\d+$/)) {
            alert("Il telefono deve contenere solo numeri.");
            return;
        }        

        aggiornaProfilo(data);
    });
});

async function aggiornaProfilo(data) {
    const submitButton = document.querySelector("button[type='submit']");
    submitButton.disabled = true;
    submitButton.textContent = "Caricamento...";

    try {
        const response = await fetch("Ajax/api-updateProfile.php", {
            method: "POST",
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data),
        });

        if (!response.ok) {
            if (response.status === 400) {
                alert("Errore nella richiesta. Controlla i dati inseriti.");
            } else if (response.status === 500) {
                alert("Errore del server. Riprova più tardi.");
            } else {
                throw new Error("Errore nella risposta del server");
            }
            return;
        }

        const result = await response.json();
        if (result.success) {
            alert("Profilo aggiornato con successo!");
            // Aggiorna dinamicamente il DOM
            document.getElementById("nomeUtente").value = data.nome;
            document.getElementById("cognomeUtente").value = data.cognome;
            document.getElementById("emailUtente").value = data.email;
            document.getElementById("telefonoUtente").value = data.telefono;
        } else {
            alert("Errore: " + (result.message || "Impossibile aggiornare il profilo."));
        }
    } catch (error) {
        console.error("Errore intercettato:", error);
        alert("Si è verificato un errore. Riprova.");
    } finally {
        submitButton.disabled = false;
        submitButton.textContent = "Salva";
    }
}

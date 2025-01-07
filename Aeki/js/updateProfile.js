document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("modificaProfiloForm");

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        // Ottiene i dati dal form
        const formData = new FormData(form);
        const data = {
            nome: formData.get('nome') || "",
            cognome: formData.get('cognome') || "",
            email: formData.get('email') || "",
            telefono: formData.get('telefono') || ""
        };

        // Chiama la funzione aggiornaProfilo con i dati del form
        aggiornaProfilo(data);
    });
});

async function aggiornaProfilo(data) {
    try {
        const response = await fetch("Ajax/api-updateProfile.php", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });

        if (!response.ok) {
            throw new Error("Errore nella risposta del server");
        }

        const result = await response.json();
        if (result.success) {
            alert("Profilo aggiornato con successo!");
            window.location.reload();
        } else {
            alert("Errore: " + (result.message || "Impossibile aggiornare il profilo."));
        }
    } catch (error) {
        console.error("Errore intercettato:", error);
        alert("Si è verificato un errore. Riprova.");
    }
}

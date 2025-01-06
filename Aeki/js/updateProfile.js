document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("modificaProfiloForm");

    form.addEventListener("submit", function (e) {
        e.preventDefault(); 

        // Ottieni i dati dal modulo
        const formData = new FormData(form);
        const data = {
            nome: formData.get('nome') || "",
            cognome: formData.get('cognome') || "",
            email: formData.get('email' || ""),
            telefono: formData.get('telefono') || ""  
        };

        // Invia i dati come JSON
        fetch("template/modificaProfilo.php", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),  // Converte l'oggetto in una stringa JSON
        })
        .then(response => {
            if (!response.ok) {
                throw new Error("Errore nella risposta del server");
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                alert("Profilo aggiornato con successo!");
                window.location.href = "../profile.php";
            } else {
                alert("Errore: " + (data.message || "Impossibile aggiornare il profilo."));
            }
        })
        .catch(error => {
            console.error("Errore nella comunicazione con il server:", error);
            alert("Si è verificato un errore. Riprova.");
        });
    });
});

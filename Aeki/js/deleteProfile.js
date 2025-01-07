document.getElementById("deleteAccountBtn").addEventListener("click", function() {
    // Log per verificare che l'utente ha cliccato il pulsante
    console.log("Eliminazione account confermata.");

    // Crea una richiesta AJAX
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "Ajax/api-deleteProfile.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");

    // Log prima di inviare la richiesta
    console.log("Invio della richiesta di eliminazione dell'account...");

    // Gestisci la risposta dal server
    xhr.onload = function() {
        // Log della risposta del server
        console.log("Risposta del server ricevuta:", xhr.status, xhr.responseText);
    
        if (xhr.status === 200) {
            try {
                const response = JSON.parse(xhr.responseText);
                console.log("Risposta JSON:", response);
    
                if (response.success) {
                    document.getElementById("message").innerHTML = `<p style="color: green;">${response.message}</p>`;
                    window.location.href = "/ProgettoWeb/Aeki/homePage.php"; // Reindirizza alla home
                } else {
                    document.getElementById("message").innerHTML = `<p style="color: red;">${response.message}</p>`;
                }
            } catch (e) {
                // Gestione dell'errore se la risposta non è un JSON valido
                document.getElementById("message").innerHTML = `<p style="color: red;">Errore di parsing della risposta: ${e.message}</p>`;
                console.error('Errore di parsing JSON:', e);
            }
        } else {
            document.getElementById("message").innerHTML = `<p style="color: red;">Errore del server. Riprova più tardi.</p>`;
            console.error('Errore durante la richiesta AJAX:', xhr.status, xhr.statusText);
        }
    };
    
    // Invia la richiesta al server
    xhr.send();

    // Log che la richiesta è stata inviata
    console.log("Richiesta inviata al server.");
});

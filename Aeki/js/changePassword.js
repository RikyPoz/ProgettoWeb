document.getElementById("cambiaPasswordModal").addEventListener("submit", function(event) {
    event.preventDefault(); // Previene il comportamento predefinito del form

    // Ottieni i valori dei campi del form
    const passwordAttuale = document.getElementById("passwordAttuale").value;
    const nuovaPassword = document.getElementById("nuovaPassword").value;

    // Verifica che i campi non siano vuoti
    if (!passwordAttuale || !nuovaPassword) {
        document.getElementById("message").innerHTML = `<p style="color: red;">Entrambi i campi sono richiesti.</p>`;
        return; // Ferma l'esecuzione se i campi sono vuoti
    }

    // Crea l'oggetto dei dati da inviare
    const data = {
        passwordAttuale: passwordAttuale,
        nuovaPassword: nuovaPassword
    };

    // Crea una richiesta AJAX
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "Ajax/api-changePassword.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");

    // Gestisce la risposta dal server
    xhr.onload = function() {
        // Log della risposta del server
        console.log("Risposta del server:", xhr.status, xhr.responseText);
    
        if (xhr.status === 200) {
            try {
                const response = JSON.parse(xhr.responseText);
                console.log("Risposta JSON:", response);
    
                // Mostra il messaggio di successo o errore
                const messageElement = document.getElementById("message");
                if (response.success) {
                    messageElement.innerHTML = `<p style="color: green;">${response.message}</p>`;
                    // Chiude il modal se la password è cambiata con successo
                    document.getElementById("cambiaPasswordModal").style.display = "none";
                    // Reindirizza alla pagina di login
                    window.location.href = "login.php";
                } else {
                    messageElement.innerHTML = `<p style="color: red;">${response.message}</p>`;
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

    // Gestisce eventuali errori di rete
    xhr.onerror = function() {
        document.getElementById("message").innerHTML = `<p style="color: red;">Errore di rete. Riprova più tardi.</p>`;
        console.error('Errore di rete:', xhr.statusText);
    };
    
    // Invia la richiesta al server con i dati JSON
    xhr.send(JSON.stringify(data));

    // Log che la richiesta è stata inviata
    console.log("Richiesta inviata al server.");
});

document.getElementById("cambiaPasswordForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Previene il comportamento predefinito del form

    // Ottieni i valori dei campi del form
    const passwordAttuale = document.getElementById("passwordAttuale").value;
    const nuovaPassword = document.getElementById("nuovaPassword").value;
    const confermaNuovaPassword = document.getElementById("confermaNuovaPassword").value;

    // Verifica che i campi non siano vuoti
    if (!passwordAttuale || !nuovaPassword || !confermaNuovaPassword) {
        document.getElementById("message-container").innerHTML = `<p style="color: red;">Tutti i campi sono richiesti.</p>`;
        return; // Ferma l'esecuzione se i campi sono vuoti
    }

    // Verifica che le nuove password coincidano
    if (nuovaPassword !== confermaNuovaPassword) {
        document.getElementById("message-container").innerHTML = `<p style="color: red;">Le nuove password non coincidono.</p>`;
        return; // Ferma l'esecuzione se le password non corrispondono
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
        if (xhr.status === 200) {
            try {
                const response = JSON.parse(xhr.responseText);
    
                // Mostra il messaggio di successo o errore
                const messageElement = document.getElementById("message-container");
                if (response.success) {
                    messageElement.innerHTML = `<p style="color: green;">${response.message}</p>`;
                    // Ritardo di 2 secondi (2000 millisecondi) prima di chiudere il modal e reindirizzare
                    setTimeout(function() {
                        document.getElementById("cambiaPasswordModal").style.display = "none";
                        // Reindirizza alla pagina di login
                        window.location.href = "login.php";
                    }, 2000); // Attendere 2 secondi prima del reindirizzamento
                } else {
                    messageElement.innerHTML = `<p style="color: red;">${response.message}</p>`;
                }
            } catch (e) {
                document.getElementById("message-container").innerHTML = `<p style="color: red;">Errore di parsing della risposta: ${e.message}</p>`;
                console.error('Errore di parsing JSON:', e);
            }
        } else {
            document.getElementById("message-container").innerHTML = `<p style="color: red;">Errore del server. Riprova piÃ¹ tardi.</p>`;
            console.error('Errore durante la richiesta AJAX:', xhr.status, xhr.statusText);
        }
    };

    // Gestisce eventuali errori di rete
    xhr.onerror = function() {
        document.getElementById("message-container").innerHTML = `<p style="color: red;">Errore di rete. Riprova piÃ¹ tardi.</p>`;
        console.error('Errore di rete:', xhr.statusText);
    };
    
    // Invia la richiesta al server con i dati JSON
    xhr.send(JSON.stringify(data));
});
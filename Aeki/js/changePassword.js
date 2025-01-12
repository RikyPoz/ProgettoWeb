document.getElementById("cambiaPasswordForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Previene il comportamento predefinito del form

    // Ottieni i valori dei campi del form
    const passwordAttuale = document.getElementById("passwordAttuale").value;
    const nuovaPassword = document.getElementById("nuovaPassword").value;
    const confermaNuovaPassword = document.getElementById("confermaNuovaPassword").value;

    // Reset del messaggio di errore
    document.querySelector(".message-container").innerHTML = '';

    // Verifica che i campi non siano vuoti
    if (!passwordAttuale || !nuovaPassword || !confermaNuovaPassword) {
        document.querySelector(".message-container").innerHTML = `<p style="color: red;">Tutti i campi sono richiesti.</p>`;
        return; // Ferma l'esecuzione se i campi sono vuoti
    }

    // Verifica che le nuove password coincidano
    if (nuovaPassword !== confermaNuovaPassword) {
        document.querySelector(".message-container").innerHTML = `<p style="color: red;">Le nuove password non corrispondono.</p>`;
        return;
    }

    // Aggiungi la logica per inviare i dati al server
    fetch('Ajax/api-changePassword.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            passwordAttuale: passwordAttuale,
            nuovaPassword: nuovaPassword
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Messaggio di successo
            document.querySelector(".message-container").innerHTML = `<p style="color: green;">Password cambiata con successo! Reindirizzamento in corso...</p>`;
            // Ritardo di 2 secondi (2000 millisecondi) prima di chiudere il modal e reindirizzare
            setTimeout(function() {
                document.getElementById("cambiaPasswordModal").style.display = "none";
            }, 2000); // Attendere 2 secondi prima del reindirizzamento
            // Chiedi conferma per aggiornare i cookie
            setTimeout(function() {
                // Mostra un messaggio per chiedere se l'utente vuole aggiornare i cookie
                const cookieUpdateMessage = document.createElement('div');
                cookieUpdateMessage.innerHTML = `
                    <div class="alert alert-info" style="position: fixed; top: 10px; left: 10px; right: 10px; z-index: 1050; background-color: white; color: black; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                        <p><strong>Vuoi memorizzare la nuova password nei cookie?</strong></p>
                        <div style="display: flex; gap: 10px;">
                            <button id="acceptCookieUpdate" class="btn btn-success btn-sm">Accetta</button>
                            <button id="rejectCookieUpdate" class="btn btn-danger btn-sm">Rifiuta</button>
                        </div>
                    </div>
                `;
                document.body.appendChild(cookieUpdateMessage);

                // Aggiungi l'overlay sfocato
                const overlay = document.createElement('div');
                overlay.style.position = 'fixed';
                overlay.style.top = '0';
                overlay.style.left = '0';
                overlay.style.right = '0';
                overlay.style.bottom = '0';
                overlay.style.backgroundColor = 'rgba(0, 0, 0, 0.3)';
                overlay.style.filter = 'blur(5px)';
                overlay.style.zIndex = '999';  // Il valore è inferiore rispetto al messaggio
                document.body.appendChild(overlay);

                // Gestisci l'accettazione dei cookie
                document.getElementById('acceptCookieUpdate').addEventListener('click', function() {
                    setCookie('userPassword', nuovaPassword, 30); // Memorizza la nuova password nei cookie per 30 giorni
                    // Rimuovi il messaggio e l'overlay
                    document.body.removeChild(cookieUpdateMessage);
                    document.body.removeChild(overlay);
                    // Procedi con il reindirizzamento
                    document.getElementById("cambiaPasswordModal").style.display = "none";
                    window.location.href = "login.php";
                });

                // Gestisci il rifiuto dei cookie
                document.getElementById('rejectCookieUpdate').addEventListener('click', function() {
                    clearCookie('userPassword'); // Elimina il cookie della password
                    // Rimuovi il messaggio e l'overlay
                    document.body.removeChild(cookieUpdateMessage);
                    document.body.removeChild(overlay);
                    // Procedi con il reindirizzamento
                    setTimeout(function() {
                        document.getElementById("cambiaPasswordModal").style.display = "none";
                        window.location.href = "login.php";
                    }, 2000);
                });
                
            }, 2000); // Mostra il messaggio di conferma dopo 2 secondi
        } else {
            document.querySelector(".message-container").innerHTML = `<p style="color: red;">${data.message}</p>`;
        }
    })
    .catch(error => {
        document.querySelector(".message-container").innerHTML = `<p style="color: red;">Si è verificato un errore. Riprova più tardi.</p>`;
    });
});
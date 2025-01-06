document.addEventListener("DOMContentLoaded", function () {
    const registerForm = document.querySelector("form#registerForm");
    
    registerForm.addEventListener("submit", function (e) {
        e.preventDefault(); // Evita il comportamento di submit del form tradizionale

        // Ottieni i dati dal form
        const firstName = document.getElementById('first-name').value;
        const lastName = document.getElementById('last-name').value;
        const username = document.getElementById('username').value;
        const email = document.getElementById('new-email').value;
        const phone = document.getElementById('phone').value;
        const password = document.getElementById('new-password').value;
        const confirmPassword = document.getElementById('confirm-password').value;

        // Validazione dei campi (ad esempio, verifica che le password siano uguali)
        if (password !== confirmPassword) {
            alert("Le password non corrispondono.");
            return;
        }

        // Creazione dell'oggetto con i dati da inviare
        const data = {
            first_name: firstName,
            last_name: lastName,
            username: username,
            email: email,
            phone: phone,
            password: password
        };

        // Invio dei dati tramite AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'Ajax/api-register.php', true);
        xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');

        xhr.onload = function () {
            console.log("Risposta grezza del server: ", xhr.responseText); // Stampa la risposta grezza

            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);

                // Se la registrazione è andata a buon fine, mostra un messaggio di successo
                const messageContainer = document.getElementById("message-container"); // Aggiungi questo contenitore HTML per il messaggio

                if (response.success) {
                    // Mostra il messaggio di successo
                    messageContainer.innerHTML = `<p style="color: green;">${response.message}</p>`;
                    window.location.href = '/ProgettoWeb/Aeki/login.php'; // Usa il percorso assoluto
                } else {
                    // Mostra l'errore
                    messageContainer.innerHTML = `<p style="color: red;">${response.message}</p>`;
                }
            } else {
                alert('Errore del server. Riprova più tardi.');
            }
        };

        // Gestisci l'errore di rete o server
        xhr.onerror = function () {
            alert("Errore di rete. Si prega di riprovare.");
        };

        // Invia i dati JSON
        xhr.send(JSON.stringify(data));
    });
});

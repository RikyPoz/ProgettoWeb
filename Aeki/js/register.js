document.addEventListener("DOMContentLoaded", function () {
    const registerForm = document.querySelector("form#registerForm");

    registerForm.addEventListener("submit", function (e) {
        e.preventDefault(); 

        // Ottiene i dati dal form
        const firstName = document.getElementById('first-name').value;
        const lastName = document.getElementById('last-name').value;
        const username = document.getElementById('username').value;
        const email = document.getElementById('new-email').value;
        const phone = document.getElementById('phone').value;
        const password = document.getElementById('new-password').value;
        const confirmPassword = document.getElementById('confirm-password').value;

        // Validazione dei campi (verifica che le password siano uguali)
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
        xhr.open('POST', 'Ajax/login/api-register.php', true);
        xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');

        xhr.onload = function () {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);

                // Se la registrazione è andata a buon fine mostra un messaggio di successo
                const messageContainer = document.getElementById("message-container");

                if (response.success) {
                    messageContainer.innerHTML = `<p style="color: #006400;">Registrazione completata! Effettua il login.</p>`;
                    
                    // Attendi 2 secondi e poi reindirizza alla pagina di login
                    setTimeout(() => {
                        window.location.href = '/ProgettoWeb/Aeki/login.php';
                    }, 2000);
                } else {
                    messageContainer.innerHTML = `<p style="color: #B00000;">${response.message}</p>`;
                }
            } else {
                alert('Errore del server. Riprova più tardi.');
            }
        };

        xhr.onerror = function () {
            alert("Errore di rete. Si prega di riprovare.");
        };

        xhr.send(JSON.stringify(data));
    });
});

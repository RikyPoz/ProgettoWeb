document.getElementById('loginButton').addEventListener('click', function () {
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    // Validazione semplice
    if (!email || !password) {
        document.getElementById('loginMessage').innerHTML = '<div class="alert alert-danger">Inserisci tutti i campi.</div>';
        return;
    }

    // Invio dati al server tramite AJAX
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'Ajax/api-login.php', true);
    console.log('Invio richiesta a:', 'Ajax/api-login.php');
    xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');

    xhr.onload = function () {
        if (xhr.status === 200) {

            try {
                const response = JSON.parse(xhr.responseText); 

                if (response.success) {
                    document.getElementById('loginMessage').innerHTML = '<div class="alert alert-success">Login effettuato con successo. Reindirizzamento...</div>';
                    setTimeout(() => {
                        // Redirige in base al tipo di utente
                        if (response.redirect) {
                            window.location.href = response.redirect;
                        }
                    }, 2000);
                } else {
                    document.getElementById('loginMessage').innerHTML = `<div class="alert alert-danger">${response.message}</div>`;
                }
            } catch (error) {
                // Se non riesce a fare il parsing, mostra un messaggio di errore
                console.error('Errore di parsing JSON:', error);
                document.getElementById('loginMessage').innerHTML = '<div class="alert alert-danger">Errore nella risposta del server. Riprova più tardi.</div>';
            }
        } else {
            document.getElementById('loginMessage').innerHTML = '<div class="alert alert-danger">Errore del server. Riprova più tardi.</div>';
        }
    };

    xhr.send(JSON.stringify({ email: email, password: password }));
});

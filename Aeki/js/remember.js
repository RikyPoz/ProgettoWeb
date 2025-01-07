// Funzione per ottenere il valore di un cookie dato il nome
function getCookie(name) {
    const nameEQ = name + "=";
    const ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i].trim();
        if (c.indexOf(nameEQ) === 0) {
            return c.substring(nameEQ.length, c.length);
        }
    }
    return null;
}

// Funzione per impostare il cookie
function setCookie(name, value, days) {
    const expires = new Date();
    expires.setTime(expires.getTime() + (days * 24 * 60 * 60 * 1000)); // Imposta la data di scadenza
    document.cookie = `${name}=${value}; expires=${expires.toUTCString()}; path=/`;
}

// Funzione per cancellare il cookie
function clearCookie(name) {
    document.cookie = `${name}=; max-age=0; path=/`; // Impostando max-age a 0 si elimina il cookie
}

// Gestisce il login con la selezione "Ricordami"
document.getElementById('loginButton').addEventListener('click', function () {
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const rememberMe = document.getElementById('remember').checked; // Verifica se la casella "Ricordami" è selezionata

    // Validazione dei campi
    if (!email || !password) {
        document.getElementById('loginMessage').innerHTML = '<div class="alert alert-danger">Inserisci tutti i campi.</div>';
        return;
    }

    // Invio dei dati tramite AJAX
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'Ajax/api-login.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');

    xhr.onload = function () {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);

            if (response.success) {
                // Se "Ricordami" è selezionato crea un cookie con email e password
                if (rememberMe) {
                    setCookie('userEmail', email, 30); // Imposta il cookie per 30 giorni
                    setCookie('userPassword', password, 30); // Imposta il cookie per la password (non sicuro)
                }

                document.getElementById('loginMessage').innerHTML = '<div class="alert alert-success">Login effettuato con successo. Reindirizzamento...</div>';
                setTimeout(() => {
                    window.location.href = './profile.php'; // Reindirizza alla pagina del profilo
                }, 2000);
            } else {
                document.getElementById('loginMessage').innerHTML = `<div class="alert alert-danger">${response.message}</div>`;
            }
        } else {
            document.getElementById('loginMessage').innerHTML = '<div class="alert alert-danger">Errore del server. Riprova più tardi.</div>';
        }
    };

    xhr.send(JSON.stringify({ email: email, password: password }));
});

// Se esiste il cookie, pre-compilare il modulo di login con il cookie
window.onload = function() {
    const emailCookie = getCookie('userEmail');
    const passwordCookie = getCookie('userPassword');
    
    if (emailCookie && passwordCookie) {
        document.getElementById('email').value = emailCookie;
        document.getElementById('password').value = passwordCookie; // Pre-compila anche la password
        document.getElementById('remember').checked = true; // Se c'è un cookie, la casella "Ricordami" è selezionata
    }
};

// Funzione per effettuare il logout e rimuovere i cookie
function logout() {
    clearCookie('userEmail');
    clearCookie('userPassword');
    window.location.href = '/login'; // Reindirizza alla pagina di login
}

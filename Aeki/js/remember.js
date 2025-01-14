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

// Funzione per effettuare il logout e rimuovere i cookie
function logout() {
    clearCookie('userEmail');
    clearCookie('userPassword');
    window.location.href = '/login'; // Reindirizza alla pagina di login
}

// Mostra il messaggio di informativa sui cookie
function showCookieNotice() {
    if (getCookie('cookieConsent')) return; // Non mostrare se già accettato

    const notice = document.createElement('div');
    notice.id = 'cookieNotice';
    notice.innerHTML = `
        <div class="alert alert-info" style="position: fixed; top: 10px; left: 10px; right: 10px; z-index: 1000; background-color: white; color: black; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
            <p><strong>Informativa sull'uso dei cookie</strong></p>
            <p>Utilizziamo i cookie per offrirti la migliore esperienza possibile sul nostro sito web. 
            Hai la possibilità di accettare tutti i cookie o rifiutarli secondo le tue preferenze. 
            Per saperne di più su come utilizziamo i cookie e su come puoi modificarne le impostazioni, consulta la nostra Informativa sui Cookie. 
            Cliccando su "Accetta", acconsenti all'utilizzo di tutti i cookie.</p>
            <div style="display: flex; gap: 10px;">
                <button id="acceptCookies" class="btn btn-sm" style="background-color: #000060; color: #FFFFFF; border-color: #0000070; font-size: 12px; padding: 8px 16px;">Accetta</button>
                <button id="rejectCookies" class="btn btn-sm" style="background-color: #B00000; color: #FFFFFF"; border-color: #B00000; font-size: 12px; padding: 8px 16px;">Rifiuta</button>
            </div>
        </div>
    `;

    // Crea un overlay sfocato sotto il messaggio
    const overlay = document.createElement('div');
    overlay.id = 'cookieOverlay';
    overlay.style.position = 'fixed';
    overlay.style.top = '0';
    overlay.style.left = '0';
    overlay.style.right = '0';
    overlay.style.bottom = '0';
    overlay.style.backgroundColor = 'rgba(0, 0, 0, 0.3)';
    overlay.style.filter = 'blur(5px)'; // Applica la sfocatura
    overlay.style.zIndex = '999'; // Posiziona l'overlay sotto il messaggio

    // Applica l'overlay sopra la pagina
    document.body.appendChild(overlay);

    // Mostra l'informativa sui cookie
    document.body.appendChild(notice);

    // Rimuovi l'overlay e il messaggio quando l'utente interagisce
    document.getElementById('acceptCookies').addEventListener('click', function () {
        document.body.removeChild(overlay); // Rimuove l'overlay
        document.getElementById('cookieNotice').remove(); // Rimuovi il messaggio
    });

    document.getElementById('rejectCookies').addEventListener('click', function () {
        document.body.removeChild(overlay); // Rimuove l'overlay
        document.getElementById('cookieNotice').remove(); // Rimuovi il messaggio
    });

    // Gestisci l'accettazione dei cookie
    document.getElementById('acceptCookies').addEventListener('click', function () {
        setCookie('cookieConsent', 'accepted', 365); // Memorizza il consenso
        document.getElementById('remember').checked = true; // Mantieni la spunta
        document.body.removeChild(notice); // Rimuovi il messaggio
    });

    // Gestisci il rifiuto dei cookie
    document.getElementById('rejectCookies').addEventListener('click', function () {
        document.getElementById('remember').checked = false; // Rimuovi la spunta
        document.body.removeChild(notice); // Rimuovi il messaggio
    });
}

// Aggiungi un event listener alla casella "Ricordami"
document.getElementById('remember').addEventListener('change', function () {
    if (this.checked) {
        showCookieNotice(); // Mostra l'informativa sui cookie
    }
});

// Se esiste il cookie, pre-compilare il modulo di login con il cookie
window.onload = function () {
    const emailCookie = getCookie('userEmail');
    const passwordCookie = getCookie('userPassword');

    if (emailCookie && passwordCookie) {
        document.getElementById('email').value = emailCookie;
        document.getElementById('password').value = passwordCookie; // Pre-compila la password
        document.getElementById('remember').checked = true; // Se c'è un cookie la casella "Ricordami" è selezionata
    }
};

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
    xhr.open('POST', 'Ajax/login/api-login.php', true);
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
                    window.location.href = response.redirect; // Reindirizza alla pagina del profilo
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

// Gestisce la cancellazione dell'account
document.getElementById("deleteAccountBtn").addEventListener("click", function () {
    if (!confirm("Sei sicuro di voler eliminare il tuo account? Questa azione è irreversibile.")) {
        return;
    }

    // Crea una richiesta AJAX
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "Ajax/profile/api-deleteProfile.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");

    xhr.onload = function () {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);

            if (response.success) {
                // Elimina i cookie utilizzando la funzione clearCookie
                clearCookie('userEmail');
                clearCookie('userPassword');

                document.getElementById("message").innerHTML = `<p style="color: green;">${response.message}</p>`;
                setTimeout(() => {
                    window.location.href = "/ProgettoWeb/Aeki/homePage.php"; // Reindirizza alla homepage
                }, 2000);
            } else {
                document.getElementById("message").innerHTML = `<p style="color: red;">${response.message}</p>`;
            }
        } else {
            document.getElementById("message").innerHTML = '<p style="color: red;">Errore del server. Riprova più tardi.</p>';
        }
    };

    xhr.send();
});

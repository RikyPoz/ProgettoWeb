let ultimaData = null; // Variabile globale per tracciare la data dell'ultimo messaggio ricevuto

document.addEventListener("DOMContentLoaded", function () {
    aggiornaMessaggi(); // Carica i messaggi iniziali 
    setInterval(() => aggiornaMessaggi(), 5000); // Esegue l'aggiornamento ogni 5 secondi
});

async function aggiornaMessaggi() {
    // Prepara i dati
    const data = {
        ultimaData
    };

    try {
        const response = await fetch('Ajax/profile/api-updateMessages.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });

        if (!response.ok) {
            throw new Error(`Errore nella richiesta: ${response.status}`);
        }

        const json = await response.json();
        console.log("Risposta dal server:", json);

        if (json.success) {
            if (json.messages && json.messages.length > 0) {
                // Trova il messaggio più recente
                const messaggioPiuRecente = json.messages[json.messages.length - 1];
                console.log("Messaggio più recente:", messaggioPiuRecente);

                // Confronta la data dell'ultimo messaggio con ultimaData
                if (ultimaData === null || messaggioPiuRecente.Data > ultimaData) {
                    aggiornaMessaggiUI(json.messages); // Aggiorna la UI con i nuovi messaggi
                    ultimaData = messaggioPiuRecente.Data; // Aggiorna ultimaData solo se il nuovo messaggio è più recente
                    console.log("Aggiornata ultimaData a:", ultimaData);
                } else {
                    console.log("Nessun nuovo messaggio trovato.");
                }
            } else {
                console.log("Nessun messaggio trovato.");
            }
        } else {
            console.error(`Errore ricevuto dal server: ${json.message}`);
        }
    } catch (error) {
        console.error(`Errore durante l'aggiornamento dei messaggi: ${error.message}`);
    }
}

function aggiornaMessaggiUI(messaggi) {
    const messaggiContainer = document.querySelector('#messaggi-container');
    if (!messaggiContainer) {
        console.error('Contenitore dei messaggi non trovato!');
        return;
    }

    const noMessagesElement = document.querySelector('#no-messages');

    // Se ci sono nuovi messaggi rimuove il messaggio "Nessun messaggio disponibile"
    if (messaggi.length > 0 && noMessagesElement) {
        noMessagesElement.remove();
    }

    // Ottiene gli ID dei messaggi già presenti nella UI per evitare duplicati
    const existingMessageIds = Array.from(messaggiContainer.children)
        .filter(item => item.id !== 'no-messages') // Esclude il messaggio "Nessun messaggio disponibile"
        .map(item => item.querySelector('span.message-id')?.textContent);

    messaggi.forEach(messaggio => {
        if (!messaggio.IdNotifica) {
            console.error("ID del messaggio mancante:", messaggio);
            return;
        }

        if (existingMessageIds.includes(messaggio.IdNotifica)) {
            console.log(`Messaggio già presente: ${messaggio.Data} on ID ${messaggio.IdNotifica}`);
            return;
        }

        const listItem = document.createElement('li');
        listItem.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');

        const testoSpan = document.createElement('span');
        testoSpan.textContent = messaggio.Testo;

        if (messaggio.Letta === 'N') {
            testoSpan.style.fontWeight = 'bold';
            listItem.classList.add('unread');
            listItem.addEventListener('click', () => leggiMessaggio(messaggio.IdNotifica, listItem, testoSpan));
        }

        const dataSpan = document.createElement('span');
        dataSpan.classList.add('text-muted');
        dataSpan.textContent = messaggio.Data;

        const idSpan = document.createElement('span');
        idSpan.classList.add('message-id');
        idSpan.style.display = 'none';
        idSpan.textContent = messaggio.IdNotifica;

        listItem.appendChild(testoSpan);
        listItem.appendChild(dataSpan);
        listItem.appendChild(idSpan);

        messaggiContainer.prepend(listItem);
    });

    // Se non ci sono messaggi aggiunge "Nessun messaggio disponibile"
    if (messaggiContainer.children.length === 0 && !noMessagesElement) {
        const noMessagesItem = document.createElement('li');
        noMessagesItem.id = 'no-messages';
        noMessagesItem.classList.add('text-muted');
        noMessagesItem.textContent = 'Nessun messaggio disponibile.';
        messaggiContainer.appendChild(noMessagesItem);
    }
}

async function leggiMessaggio(idNotifica, listItem, testoSpan) {
    // Verifica che l'ID del messaggio sia valido
    if (!idNotifica) {
        console.error("ID del messaggio mancante durante la lettura:", idNotifica);
        return; // Interrompe l'esecuzione se l'ID non è valido
    }

    // Invia una richiesta al server per segnare il messaggio come letto
    try {
        const response = await fetch('Ajax/profile/api-markAsRead.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ idNotifica })  // Assicurati che l'ID sia passato correttamente
        });

        const json = await response.json();
        console.log("Risposta dal server:", json);  // Log della risposta dal server

        if (!json) {
            console.error("Risposta del server mancante o non valida");
            return;
        }

        if (json.success) {
            // Rimuove il grassetto dal testo
            testoSpan.style.fontWeight = 'normal';

            // Rimuove la classe 'unread'
            listItem.classList.remove('unread');

            // Rimuove l'event listener per evitare ulteriori click
            listItem.removeEventListener('click', () => leggiMessaggio(idNotifica, listItem, testoSpan));

            console.log(`Messaggio ${idNotifica} marcato come letto`);
        } else {
            console.error(`Errore nel marcare il messaggio come letto: ${json.message}`);
        }
    } catch (error) {
        console.error(`Errore durante l'aggiornamento del messaggio: ${error.message}`);
    }
}

function caricaFoglioStile(url) {
    const esiste = Array.from(document.querySelectorAll('link')).some(link => link.href === url);
    if (!esiste) {
        const head = document.querySelector('head');
        const link = document.createElement('link');

        link.rel = 'stylesheet';
        link.type = 'text/css';
        link.href = url;

        head.appendChild(link);
        console.log(`Caricato foglio di stile: ${url}`);
    } else {
        console.log(`Foglio di stile già caricato: ${url}`);
    }
}

caricaFoglioStile('./css/updateMessages_style.css'); 

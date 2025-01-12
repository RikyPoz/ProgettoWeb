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
        const response = await fetch('Ajax/api-updateMessages.php', {
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

    console.log("Messaggi da aggiungere:", messaggi);

    // Ottieni gli ID dei messaggi già presenti nella UI per evitare duplicati
    const existingMessageIds = Array.from(messaggiContainer.children).map(item => item.querySelector('span.message-id')?.textContent);

    messaggi.forEach(messaggio => {
        // Verifica che l'ID del messaggio sia presente
        if (!messaggio.IdNotifica) {
            console.error("ID del messaggio mancante:", messaggio);
            return; // Salta il messaggio se l'ID non è valido
        }

        console.log("Messaggio:", messaggio); // Mostra il messaggio intero
        console.log("Stato del messaggio:", messaggio.Letta); // Mostra lo stato di 'Letta'        

        // Controlla se il messaggio esiste già nella UI (utilizzando sia l'ID che la Data)
        if (existingMessageIds.includes(messaggio.IdNotifica)) {
            console.log(`Messaggio già presente: ${messaggio.Data} on ID ${messaggio.IdNotifica}`);
            return; // Salta il messaggio già esistente
        }

        const listItem = document.createElement('li');
        listItem.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');

        const testoSpan = document.createElement('span');
        testoSpan.textContent = messaggio.Testo;

        // Se il messaggio non è letto (Letta = 'N'), applica il grassetto
        if (messaggio.Letta === 'N') {
            testoSpan.style.fontWeight = 'bold';
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

        messaggiContainer.prepend(listItem); // Aggiunge il nuovo messaggio all'inizio
    });
}

async function leggiMessaggio(idNotifica, listItem, testoSpan) {
    // Verifica che l'ID del messaggio sia valido
    if (!idNotifica) {
        console.error("ID del messaggio mancante durante la lettura:", idNotifica);
        return; // Interrompe l'esecuzione se l'ID non è valido
    }

    // Invia una richiesta al server per segnare il messaggio come letto
    try {
        const response = await fetch('Ajax/api-markAsRead.php', {
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
            listItem.removeEventListener('click', () => leggiMessaggio(idNotifica, listItem, testoSpan)); // Rimuove l'event listener dopo che è stato letto
            console.log(`Messaggio ${idNotifica} marcato come letto`);
        } else {
            console.error(`Errore nel marcare il messaggio come letto: ${json.message}`);
        }
    } catch (error) {
        console.error(`Errore durante l'aggiornamento del messaggio: ${error.message}`);
    }
}

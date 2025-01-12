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
        // Controlla se il messaggio esiste già nella UI (utilizzando sia l'ID che la Data)
        if (existingMessageIds.includes(messaggio.IdNotifica)) {
            console.log(`Messaggio già presente: ${messaggio.Data} on ID ${messaggio.IdNotifica}`);
            return; // Salta il messaggio già esistente
        }

        const listItem = document.createElement('li');
        listItem.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');

        const testoSpan = document.createElement('span');
        testoSpan.textContent = messaggio.Testo;

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

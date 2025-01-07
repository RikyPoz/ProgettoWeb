document.getElementById("deleteAccountBtn").addEventListener("click", function() {
    if (confirm("Sei sicuro di voler eliminare il tuo account? Questa operazione è irreversibile.")) {
        // Crea una richiesta AJAX
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "Ajax/api-deleteProfile.php", true);
        xhr.setRequestHeader("Content-Type", "application/json");

        // Gestisci la risposta dal server
        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    document.getElementById("message").innerHTML = `<p style="color: green;">${response.message}</p>`;
                    window.location.href = "/ProgettoWeb/Aeki/homePage.php"; // Reindirizza alla home
                } else {
                    document.getElementById("message").innerHTML = `<p style="color: red;">${response.message}</p>`;
                }
            } else {
                document.getElementById("message").innerHTML = `<p style="color: red;">Errore del server. Riprova più tardi.</p>`;
            }
        };

        xhr.onerror = function() {
            document.getElementById("message").innerHTML = `<p style="color: red;">Errore di rete. Riprova.</p>`;
        };

        // Invia la richiesta al server (in questo caso non sono necessari parametri aggiuntivi)
        xhr.send();
    }
});

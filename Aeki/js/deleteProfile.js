document.getElementById("deleteAccountBtn").addEventListener("click", function () {

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "Ajax/profile/api-deleteProfile.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");

    // Gestisce la risposta dal server
    xhr.onload = function () {

        if (xhr.status === 200) {
            try {
                const response = JSON.parse(xhr.responseText);

                if (response.success) {
                    document.getElementById("message").innerHTML = `<p style="color: #006400;">${response.message}</p>`; 
                    window.location.href = "/ProgettoWeb/Aeki/homePage.php"; // Reindirizza alla home
                } else {
                    document.getElementById("message").innerHTML = `<p style="color: #B00000;">${response.message}</p>`;
                }
            } catch (e) {
                // Gestione dell'errore se la risposta non è un JSON valido
                document.getElementById("message").innerHTML = `<p style="color: #B00000;">Errore di parsing della risposta: ${e.message}</p>`;
            }
        } else {
            document.getElementById("message").innerHTML = `<p style="color: #B00000;">Errore del server. Riprova più tardi.</p>`;
        }
    };

    // Invia la richiesta al server
    xhr.send();
});

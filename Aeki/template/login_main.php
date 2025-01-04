<style>
    .login-container {
        max-width: 600px;
        width: 100%;
        background-color: white;
        padding: 40px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Stile del modale */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        overflow: auto;
    }

    .modal-content {
        background-color: #fefefe;
        margin: 5% auto;
        padding: 20px;
        border-radius: 8px;
        width: 80%; 
        max-width: 500px; 
        box-sizing: border-box; 
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

</style>


<body>
    <!-- Main -->
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="login-container">
            <h2 class="text-center">Login</h2>
            <form action="/login" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required placeholder="Inserisci la tua email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required placeholder="Inserisci la tua password">
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Ricordami</label>
                </div>
                <button type="submit" class="btn btn-primary w-100">Accedi</button>
            </form>
            <div class="mt-3 text-center">
                <p>Non sei registrato? <a href="#" id="openModal">Registrati prima di fare il login.</a></p>
            </div>
        </div>
    </div>

    <!-- Modale per la registrazione -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Registrazione</h2>
            <form action="/register" method="POST">
                <div class="mb-3">
                    <label for="first-name" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="first-name" name="first-name" required placeholder="Inserisci il tuo nome">
                </div>
                <div class="mb-3">
                    <label for="last-name" class="form-label">Cognome</label>
                    <input type="text" class="form-control" id="last-name" name="last-name" required placeholder="Inserisci il tuo cognome">
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Nome utente</label>
                    <input type="text" class="form-control" id="username" name="username" required placeholder="Inserisci il tuo nome utente">
                </div>
                <div class="mb-3">
                    <label for="new-email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="new-email" name="email" required placeholder="Inserisci la tua email">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Numero di telefono</label>
                    <input type="tel" class="form-control" id="phone" name="phone" required placeholder="Inserisci il tuo numero di telefono">
                </div>
                <div class="mb-3">
                    <label for="new-password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="new-password" name="password" required placeholder="Crea una nuova password">
                </div>
                <div class="mb-3">
                    <label for="confirm-password" class="form-label">Ripeti password</label>
                    <input type="password" class="form-control" id="confirm-password" name="confirm-password" required placeholder="Ripeti password">
                </div>
                <button type="submit" class="btn btn-success w-100">Registrati</button>
            </form>
        </div>
    </div>

    <!-- Modal Script -->
    <script>
        var modal = document.getElementById("myModal");
        var btn = document.getElementById("openModal");
        var span = document.getElementsByClassName("close")[0];

        btn.onclick = function() {
            modal.style.display = "block";
        }

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>

</body>


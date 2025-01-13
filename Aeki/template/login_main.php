
<link rel="stylesheet" href="./css/login_style.css">


<div class="login-page">
    <!-- Login -->
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="login-container">
            <h2 class="text-center d-flex align-items-center justify-content-center">
                Login
                <img src="upload/logo.png" alt="Logo del sito" style="width: 60px; height: 60px;">
            </h2>
            <form id="loginForm">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required placeholder="Inserisci la tua email">
                </div>
                <div class="mb-3 position-relative">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password" required placeholder="Inserisci la tua password">
                        <span class="input-group-text" id="togglePassword" style="cursor: pointer;" aria-label="Mostra password">
                            <i class="bi bi-eye" id="toggleIcon"></i>
                        </span>
                    </div>
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Ricordami</label>
                </div>
                <button type="button" class="btn" style="background-color: #000060;color:#FFFFFF" id="loginButton">Accedi</button>
            </form>
            <div id="loginMessage" class="mt-3"></div>
            <div class="mt-3 text-center">
                <p>Non sei registrato? <a href="#" id="openModal" aria-label="Apri modulo di registrazione" style="color: #000070">Registrati prima di fare il login.</a></p>
            </div>
        </div>
    </div>

<!-- Modal per la registrazione -->
<div id="myModal" class="modal" aria-hidden="true">
    <div class="modal-content">
        <span class="modal-close" aria-label="Chiudi">&times;</span>
        <h2>Registrazione</h2>

        <!-- Contenitore per il messaggio -->
        <div id="message-container"></div> 

        <form id="registerForm">
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
            <button type="submit" class="btn btn-success" style="background-color: #000060">Registrati</button>
        </form>
    </div>
</div>

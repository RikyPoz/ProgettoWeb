<head>
    <link rel="stylesheet" href="./css/profile_style.css">
</head>

<!-- Contenuto della pagina -->
<div class="container my-5">
    <div class="row">
        <!-- Sezione Profilo -->
        <section class="col-lg-7">
            <h2 class="fw-bold" style="color: #000070">Benvenuto <?php echo $templateParams["utente"]['Username']; ?>!</h2>
            <div class="border rounded p-4">
                <h3>Il tuo profilo</h3>
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control nomeUtente" value="<?php echo $templateParams["utente"]['Nome']; ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="cognome" class="form-label">Cognome</label>
                    <input type="text" class="form-control cognomeUtente" value="<?php echo $templateParams["utente"]['Cognome']; ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control emailUtente" value="<?php echo $templateParams["utente"]['Email']; ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="telefono" class="form-label">Telefono</label>
                    <input type="text" class="form-control telefonoUtente" value="<?php echo $templateParams["utente"]['Telefono']; ?>" readonly>
                </div>
                <!-- Pulsante per aprire il modale per modificare il profilo -->
                <button type="button" class="btn btn-light border" data-bs-toggle="modal" data-bs-target="#modificaProfiloModal">Modifica Profilo</button>
            </div>
            <!-- Pulsanti Cambia Password ed Elimina Account -->
            <div class="d-flex justify-content-end gap-3 mt-4">
                <!-- Pulsante Cambia Password che apre il modale -->
                <button type="button" class="btn" style="background-color: #000060;color:#FFFFFF" data-bs-toggle="modal" data-bs-target="#cambiaPasswordModal">Cambia password</button>
                <!-- Pulsante Elimina Account che apre il modale -->
                <button type="button" class="btn" style="background-color: #B00000;color:#FFFFFF" data-bs-toggle="modal" data-bs-target="#eliminaAccountModal">Elimina account</button>
            </div>
        </section>

        <!-- Aside -->
        <aside class="col-lg-5">
            <!-- Sezione Messaggi -->
            <div class="border rounded p-3 mb-4" style="height: 300px; overflow-y: auto;">
                <h3>Messaggi in arrivo</h3>
                <ul class="list-group messaggi-container" id="messaggi-container">
                    <!-- Riga mostrata se non ci sono messaggi per l'utente -->
                    <li id="no-messages" class="text-muted">Nessun messaggio disponibile.</li> 
                    <!-- Messaggi aggiunti dinamicamente -->
                </ul>
            </div>
            <!-- Sezione Recensioni -->
            <?php if ($templateParams["utente"]['Tipo'] === 'Cliente'): ?>
                <div class="border rounded p-3" style="height: 300px; overflow-y: auto;">
                    <h4>Recensioni Inviate</h4>
                    <?php if (!empty($templateParams["recensioni"])): ?>
                        <ul class="list-group">
                            <?php foreach ($templateParams["recensioni"] as $recensione): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <p><?php echo $recensione['Testo']; ?></p>
                                        <small class="text-muted">Codice Prodotto: <?php echo $recensione['CodiceProdotto']; ?></small>
                                    </div>
                                    <span class="text-muted" style="display: flex; white-space: nowrap;"><?php echo getStars($recensione['stelle']); ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>Nessuna recensione inviata.</p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </aside>
    </div>
</div>

<!-- Modifica Profilo -->
<div class="modal fade" id="modificaProfiloModal" tabindex="-1" aria-labelledby="modificaProfiloLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modificaProfiloLabel">Modifica Profilo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="modificaProfiloForm">
                    <div class="mb-3">
                        <label for="nomeUtente" class="form-label">Nome</label>
                        <input type="text" class="form-control" name="nome" value="<?php echo $templateParams["utente"]['Nome']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="cognomeUtente" class="form-label">Cognome</label>
                        <input type="text" class="form-control" name="cognome" value="<?php echo $templateParams["utente"]['Cognome']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="emailUtente" class="form-label">E-mail</label>
                        <input type="email" class="form-control" name="email" value="<?php echo $templateParams["utente"]['Email']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="telefonoUtente" class="form-label">Telefono</label>
                        <input type="text" class="form-control" name="telefono" value="<?php echo $templateParams["utente"]['Telefono']; ?>">
                    </div>
                    <button type="submit" class="btn" style="background-color:#000060;color:#FFFFFF">Salva Modifiche</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Cambia Password -->
<div class="modal fade" id="cambiaPasswordModal" tabindex="-1" aria-labelledby="cambiaPasswordLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cambiaPasswordLabel">Cambia la tua password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Contenitore per il messaggio di errore -->
                <div class="message-container" style="margin-bottom: 15px;"></div>
                <form id="cambiaPasswordForm">
                    <!-- Password Attuale -->
                    <div class="mb-3">
                        <label for="passwordAttuale" class="form-label">Password Attuale</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="passwordAttuale" name="passwordAttuale" required>
                            <button type="button" class="btn btn-outline-secondary togglePasswordAttuale" id="togglePasswordAttuale">
                                <i class="bi bi-eye" id="toggleIconAttuale"></i>
                            </button>
                        </div>
                    </div>
                    <!-- Nuova Password -->
                    <div class="mb-3">
                        <label for="nuovaPassword" class="form-label">Nuova Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="nuovaPassword" name="nuovaPassword" required>
                            <button type="button" class="btn btn-outline-secondary togglePasswordNuova" id="togglePasswordNuova">
                                <i class="bi bi-eye" id="toggleIconNuova"></i>
                            </button>
                        </div>
                    </div>
                    <!-- Conferma Nuova Password -->
                    <div class="mb-3">
                        <label for="confermaNuovaPassword" class="form-label">Conferma Nuova Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="confermaNuovaPassword" name="confermaNuovaPassword" required>
                            <button type="button" class="btn btn-outline-secondary togglePasswordConferma" id="togglePasswordConferma">
                                <i class="bi bi-eye" id="toggleIconConferma"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="btn" style="background-color: #000060;color:#FFFFFF">Cambia Password</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Elimina Account -->
<div class="modal fade" id="eliminaAccountModal" tabindex="-1" aria-labelledby="eliminaAccountLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminaAccountLabel">Elimina Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Sei sicuro di voler eliminare il tuo account? Questa azione è irreversibile.</p>
                <button type="button" class="btn" style="background-color: #B00000;color:#FFFFFF">Elimina Account</button>
                <div class="message"></div> <!-- Contenitore per i messaggi di successo o errore -->
            </div>
        </div>
    </div>
</div>
<head>
    <!-- DA ELIMINARE QUANDO SI USA BASE.PHP -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profilo Utente</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <!-- Icone Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

    <!-- Contenuto della pagina -->
    <div class="container my-5">
        <div class="row">
            <!-- Sezione Profilo -->
            <section class="col-lg-8">
                <h2>Benvenuto <?php echo $templateParams["utente"]['Username']; ?>!</h2>
                <div class="border rounded p-4">
                    <h3>Il tuo profilo</h3>
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nome" value="<?php echo $templateParams["utente"]['nome']; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="cognome" class="form-label">Cognome</label>
                        <input type="text" class="form-control" id="cognome" value="<?php echo $templateParams["utente"]['cognome']; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" value="<?php echo $templateParams["utente"]['email']; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Telefono</label>
                        <input type="text" class="form-control" id="telefono" value="<?php echo $templateParams["utente"]['telefono']; ?>" readonly>
                    </div>
                    <!-- Pulsante per aprire il modale per modificare il profilo -->
                    <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#modificaProfiloModal">Modifica Profilo</button>
                </div>
                <!-- Pulsanti Cambia Password ed Elimina Account -->
                <div class="d-flex justify-content-end gap-3 mt-4">
                    <!-- Pulsante Cambia Password che apre il modale -->
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#cambiaPasswordModal">Cambia password</button>
                    <!-- Pulsante Elimina Account che apre il modale -->
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#eliminaAccountModal">Elimina account</button>
                </div>
            </section>

            <!-- Sezione Messaggi e Recensioni -->
            <aside class="col-lg-4">
                <div class="border rounded p-3 mb-4">
                    <h3>Messaggi in arrivo</h3>
                    <!-- Contenitore dinamico per i messaggi -->
                    <ul class="list-group" id="messaggi-container">
                        <!-- I messaggi verranno aggiunti dinamicamente tramite JS -->
                    </ul>
                </div>

                <div class="border rounded p-3">
                    <h4>Recensioni Inviate</h4>
                    <?php if (!empty($templateParams["recensioni"])): ?>
                        <ul class="list-group">
                            <?php foreach ($templateParams["recensioni"] as $recensione): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo htmlspecialchars($recensione['contenuto']); ?> - #<?php echo htmlspecialchars($recensione['codiceProdotto']); ?>
                                    <span class="text-muted"><?php echo htmlspecialchars($recensione['dataRecensione']); ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>Nessuna recensione inviata.</p>
                    <?php endif; ?>
                </div>
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
                    <form action="modificaProfilo.php" method="POST">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $templateParams['utente']['nome']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="cognome" class="form-label">Cognome</label>
                            <input type="text" class="form-control" id="cognome" name="cognome" value="<?php echo $templateParams['utente']['cognome']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $templateParams['utente']['email']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Telefono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $templateParams['utente']['telefono']; ?>">
                        </div>
                        <button type="submit" class="btn btn-primary">Salva Modifiche</button>
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
                    <form action="cambiaPassword.php" method="POST">
                        <div class="mb-3">
                            <label for="passwordAttuale" class="form-label">Password Attuale</label>
                            <input type="password" class="form-control" id="passwordAttuale" name="passwordAttuale" required>
                        </div>
                        <div class="mb-3">
                            <label for="nuovaPassword" class="form-label">Nuova Password</label>
                            <input type="password" class="form-control" id="nuovaPassword" name="nuovaPassword" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Cambia Password</button>
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
                    <form action="eliminaAccount.php" method="POST">
                        <button type="submit" class="btn btn-danger">Elimina Account</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
   
    <!-- Inclusione del file JavaScript per aggiornare i messaggi -->
    <script src="../js/updateMessages.js"></script>

</body>
</html>

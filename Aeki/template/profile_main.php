<!DOCTYPE html>
<html lang="it">
<head>
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
                <h2>Il tuo profilo</h2>
                <div class="border rounded p-4">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nome" value="Nome Utente" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="cognome" class="form-label">Cognome</label>
                        <input type="text" class="form-control" id="cognome" value="Cognome Utente" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" value="email@example.com" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Telefono</label>
                        <input type="text" class="form-control" id="telefono" value="+39 012 345 6789" readonly>
                    </div>
                    <button type="button" class="btn btn-light">Modifica Profilo</button>
                </div>
                <!-- Pulsanti Cambia Password ed Elimina Account -->
                <div class="d-flex justify-content-end gap-3 mt-4">
                    <button type="button" class="btn btn-secondary">Cambia password</button>
                    <button type="button" class="btn btn-danger">Elimina account</button>
                </div>
            </section>

            <!-- Sezione Messaggi e Recensioni -->
            <aside class="col-lg-4">
                <div class="border rounded p-3 mb-4">
                    <h3>Messaggi in arrivo</h3>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Il tuo ordine #2plks6 è stato consegnato
                            <span class="text-muted">25/11/2021 15:30</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Il tuo ordine #2plks6 è stato consegnato
                            <span class="text-muted">25/11/2021 15:30</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Il tuo ordine #2plks6 è stato consegnato
                            <span class="text-muted">25/11/2021 15:30</span>
                        </li>
                    </ul>
                </div>

                <div class="border rounded p-3">
                    <h3>Recensioni Inviate</h3>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Divano molto comodo #codiceProdotto
                            <span class="text-muted">26/11/2021 20:30</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Divano molto comodo #codiceProdotto
                            <span class="text-muted">26/11/2021 20:30</span>
                        </li>
                    </ul>
                </div>
            </aside>
        </div>
    </div>

</body>
</html>

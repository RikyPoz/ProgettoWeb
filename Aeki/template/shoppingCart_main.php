<div class="container mt-4">
    <!-- Titolo -->
    <div class="col-12">
        <h1 class="fw-bold" id="cartTitle"></h1>
    </div>
    <div class="row">
        <!-- Riepilogo in alto per dispositivi mobili -->
        <div class="col-12 d-md-none mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Riepilogo</h5>
                    <ul class="list-group list-group-flush" id="recapTableMobile"></ul>
                    <button class="btn btn-success w-100 mt-3">Procedi all'Acquisto</button>
                </div>
            </div>
        </div>

        <!-- Prodotti nel carrello -->
        <div class="col-md-8" style="overflow-y: auto; max-height: 55vh;" id="productsContainer"></div>

        <!-- Riepilogo fisso per desktop -->
        <div class="col-md-4 d-none d-md-block">
            <div class="sticky-top" style="top: 1rem;">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Riepilogo</h5>
                        <ul class="list-group list-group-flush" id="recapTable"></ul>
                        <button class="btn btn-success w-100 mt-3">Procedi all'Acquisto</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Mantieni proporzioni immagini */
    .img-fixed {
        max-height: 100px; /* Limita l'altezza */
        width: auto; /* Mantieni le proporzioni */
        object-fit: cover; /* Adatta senza deformare */
    }

    /* Sticky-bottom per il totale */
    .sticky-bottom {
        position: sticky;
        bottom: 0;
    }

    /* Rimuovi comportamento non desiderato su schermi piccoli */
    @media (max-width: 576px) {
        .sticky-bottom {
            position: static;
        }
    }
</style>
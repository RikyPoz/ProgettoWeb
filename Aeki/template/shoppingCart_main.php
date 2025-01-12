<div class="container mt-4" style="height: 70vh">
    <!-- Titolo -->
    <div class="col-12 my-4">
        <h1 class="fw-bold" style="color: #000070" id="cartTitle"></h1>
    </div>
    <div class="row">
        <!-- Riepilogo in alto per dispositivi mobili -->
        <div class="col-12 d-md-none mb-3" id="recapTableMobile"></div>

        <!-- Prodotti nel carrello -->
        <div class="col-md-8 mb-5 " style="overflow-y: auto; max-height: 55vh;" id="productsContainer"></div>

        <!-- Riepilogo fisso per desktop -->
        <div class="col-md-4 d-none d-md-block" id="recapTable"></div>
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
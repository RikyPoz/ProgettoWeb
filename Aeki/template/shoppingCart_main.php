<div class="container mt-4">
    <!-- Titolo -->
    <div class="col-12">
        <h1 class="fw-bold">
            Carrello <span class="text-muted">(<?php echo count($templateParams["prodotti"]); ?>)</span>
        </h1>
    </div>
    <div class="row">
        <!-- Riepilogo in alto per dispositivi mobili -->
        <div class="col-12 d-md-none mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Riepilogo</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Articoli</span> 
                            <span>€<?php echo number_format(array_sum(array_column($templateParams["prodotti"], "Prezzo")), 2); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>IVA</span> 
                            <span>€<?php echo number_format(array_sum(array_column($templateParams["prodotti"], "Prezzo")) * 0.22, 2); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Spedizione</span> 
                            <span>€5,00</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between fw-bold">
                            <span>Totale</span> 
                            <span>€<?php echo number_format(array_sum(array_column($templateParams["prodotti"], "Prezzo")) * 1.22 + 5, 2); ?></span>
                        </li>
                    </ul>
                    <button class="btn btn-success w-100 mt-3">Procedi all'Acquisto</button>
                </div>
            </div>
        </div>

        <!-- Prodotti nel carrello -->
        <div class="col-md-8" style="overflow-y: auto; max-height: 75vh;">
            <?php foreach ($templateParams["prodotti"] as $prodotto): ?>
                <div class="card mb-3">
                    <div class="row g-0 align-items-center">
                        <div class="col-3 col-md-2">
                            <img src="<?php echo $prodotto["PercorsoImg"]; ?>" 
                                class="img-fluid rounded-start img-fixed" alt="Prodotto">
                        </div>
                        <div class="col-9 col-md-10">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <!-- Nome prodotto e quantità -->
                                    <div class="d-flex align-items-center flex-wrap">
                                        <h5 class="card-title mb-0 me-3">
                                            <?php echo $prodotto["Nome"]; ?>
                                        </h5>
                                        <input type="number" class="form-control form-control-sm w-auto text-center"
                                            id="<?php echo $prodotto["CodiceProdotto"]; ?>"
                                            value="<?php echo $prodotto["Quantita"]; ?>" 
                                            min="1" style="max-width: 60px;" 
                                            onchange="aggiornaQuantità(<?php echo $prodotto['CodiceProdotto']; ?>, this.value)" />
                                    </div>

                                    <!-- Checkbox e prezzo -->
                                    <div class="d-flex align-items-center">
                                        <input type="checkbox" class="form-check-input me-2 product-checkbox"
                                            onchange="aggiornaRiepilogo()"
                                            data-id="<?php echo $prodotto['CodiceProdotto']; ?>"/>
                                        <p class="mb-0 text-success fw-bold">
                                            €<?php echo number_format($prodotto["Prezzo"], 2); ?>
                                        </p>
                                    </div>
                                </div>

                                <!-- Bottoni -->
                                <div class="mt-2 d-flex gap-2">
                                    <a href="singleProduct.php?id=<?php echo $prodotto['CodiceProdotto']; ?>" 
                                    class="btn btn-outline-primary btn-sm">Visualizza Articolo</a>
                                    <button class="btn btn-outline-danger btn-sm" 
                                            onclick="rimuoviDalCarrello(<?php echo $prodotto['CodiceProdotto']; ?>)">Rimuovi</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- Totale sempre visibile -->
            <div class="text-end fw-bold sticky-bottom bg-light py-2 border-top" id="summary"></div>
        </div>

        <!-- Riepilogo fisso per desktop -->
        <div class="col-md-4 d-none d-md-block">
            <div class="sticky-top" style="top: 1rem;">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Riepilogo</h5>
                        <ul class="list-group list-group-flush" id="recapTable">    
                        </ul>
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

<script>
    function rimuoviDalCarrello(idProdotto) {
        console.log(`Rimuovi prodotto con ID: ${idProdotto}`);
    }

    function aggiornaQuantita(idProdotto, nuovaQuantità) {
        console.log(`Aggiorna quantità prodotto con ID: ${idProdotto}, nuova quantità: ${nuovaQuantità}`);
    }
</script>

<?php $prodotto = $templateParams["prodotto"];?>
<style>
.carousel-inner img {
    max-width: 100%;
    max-height: 400px;
    object-fit: contain;
}

.carousel-item img {
    transition: transform 0.1s ease, box-shadow 0.1s ease; 
    cursor: zoom-in; 
    object-fit: contain; 
}

.carousel-item img:hover {
    transform: scale(1.2); 
    box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.2); 
}
.carousel-control-prev-icon, .carousel-control-next-icon {
    filter: invert(1); /* Cambia il colore dell'icona a bianco */
}

</style>

<div class="row d-flex justify-content-center my-5">
    <div class = "col-md-10 col-12 rounded shadow bg-light p-4">
        <div class="row d-flex align-items-stretch bg-white rounded-5 ">
            <!--Img-->
            <div class="col-md-6 d-flex justify-content-center align-items-center">

                <!-- Freccia Sinistra -->
                <button class="btn me-3" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <!-- Carosello -->
                <div id="productCarousel" class="carousel slide p-2" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php foreach ($templateParams["immagini"] as $img): ?>
                            <?php if ($img["Icona"] == 'Y'): ?>
                                <div class="carousel-item active">
                                    <img src="<?php echo $img["PercorsoImg"]; ?>" class="d-block img-fluid rounded" alt="<?php echo $img["PercorsoImg"]; ?>">
                                </div>
                            <?php else : ?>
                                <div class="carousel-item">
                                    <img src="<?php echo $img["PercorsoImg"]; ?>" class="d-block img-fluid rounded" alt="<?php echo $img["PercorsoImg"]; ?>">
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <!-- Freccia Destra -->
                <button class="btn ms-3" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>

            </div>

            <!-- Descrizione Prodotto -->
            <div class="col-md-6 p-4 d-flex border-start flex-column">
                <div class="d-flex align-items-center mb-2">
                    <h1 class="fw-bold flex-grow-1 display-6 "style = "color:#000070"><?php echo $prodotto["Nome"]; ?></h1>
                    <div>
                        <?php if ($prodotto["InWishlist"] == "true"): ?>
                            <i class="bi bi-heart-fill fs-2" data-id="<?php echo htmlspecialchars($prodotto["CodiceProdotto"]); ?>" style="display:inline-block;color:#B00000"></i>
                            <i class="bi bi-heart fs-2" data-id="<?php echo htmlspecialchars($prodotto["CodiceProdotto"]); ?>" style="display:none;"></i>
                        <?php else: ?>
                            <i class="bi bi-heart-fill text-danger fs-2" data-id="<?php echo htmlspecialchars($prodotto["CodiceProdotto"]); ?>" style="display:none;"></i>
                            <i class="bi bi-heart fs-2" data-id="<?php echo htmlspecialchars($prodotto["CodiceProdotto"]); ?>" style="display:inline-block;"></i>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="mb-3">
                    <span class="fs-4 fw-semibold"><?php echo $prodotto["Prezzo"]; ?> €</span>
                </div>
                <div class="card p-3 mb-5">
                    <h5 class="card-title fs-5"><i class="bi bi-info-circle me-2"></i>Descrizione:</h5>
                    <p class="fs-6 text-muted"><?php echo $prodotto["Descrizione"]; ?></p>
                </div>
                <div class="d-flex align-items-center mb-3">
                    <label for="quantity" class="me-3 fs-5">Quantità:</label>
                    <input type="number" id="quantity" class="form-control w-25 me-3 rounded-pill px-4 text-center shadow-sm"
                        onchange="updateQuantity(<?php echo $prodotto['Disponibilita']?>)"
                        min="<?php echo $prodotto["Disponibilita"] > 0 ? 1 : 0; ?>"
                        max="<?php echo $prodotto["Disponibilita"]; ?>"
                        value="<?php echo $prodotto["Disponibilita"] > 0 ? 1 : 0; ?>">
                    <span class="text-muted fs-6">Disponibilità: 
                        <span class="fw-semibold" style="<?php echo $prodotto["Disponibilita"] < 5 ? 'color:#B00000' : ''; ?>">
                            <?php echo $prodotto["Disponibilita"]; ?>
                        </span>
                    </span>
                </div>
                <button id="addToCartButton" class="btn rounded-pill w-100 py-2 fs-5 hover-shadow" style="background-color: #000060; color: #FFFFFF" data-id="<?php echo htmlspecialchars($prodotto["CodiceProdotto"]); ?> ">
                    <i class="bi bi-cart-plus me-2"></i>Aggiungi al carrello
                </button>
                <div id="userType" data-user-type="<?php echo $templateParams["userType"]?>" style="display: none;"></div>
            </div>


        </div>
        
        <!-- Tabella con informazioni -->
        <div class="row mt-5 ">
            <div class="col-12">
                <h2 class="mb-3" style = "color:#000070">Specifiche Prodotto</h2>
                <table class="table table-bordered table-rounded">
                    <tbody>
                        <tr>
                            <th>Materiale</th>
                            <td><?php echo $prodotto["NomeMateriale"]?></td>
                        </tr>
                        <tr>
                            <th>Colore</th>
                            <td><?php echo $prodotto["NomeColore"]?></td>
                        </tr>
                        <tr>
                            <th>Largezza</th>
                            <td><?php echo $prodotto["Larghezza"]?> <span class = "text-muted">cm</span></td>
                        </tr>
                        <tr>
                            <th>Altezza</th>
                            <td><?php echo $prodotto["Altezza"]?> <span class = "text-muted">cm</span></td>
                        </tr>
                        <tr>
                            <th>Profondità</th>
                            <td><?php echo $prodotto["Profondita"]?> <span class = "text-muted">cm</span></td>
                        </tr>
                        <tr>
                            <th>Peso</th>
                            <td><?php echo $prodotto["Peso"]?> <span class = "text-muted">kg</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Sezione Recensioni del Prodotto -->
        <?php $totalReviews = $prodotto["NumeroRecensioni"]?>
        <div class="row mt-5 ">
            <div class="col-12 ">
                <h2 class="mb-3" style = "color:#000070">Recensioni Prodotto<span class = "ms-2">(<?php echo $totalReviews?>)</span></h2>
                <div class=" mb-3">
                    <span class="fs-4 text-warning"><?php echo getStars((int)$prodotto["ValutazioneMedia"]) ?></span>
                    <span class = "ms-4 fs-5 fw-semibold"><?php echo $prodotto["ValutazioneMedia"] ?> <span class = "fs-5 fw-normal"> su 5</span></span> 
                    
                </div>
                <?php foreach (range(5, 1) as $stars): ?>
                    <?php
                    $reviewCount = 0;
                    foreach ($templateParams["reviewsStats"] as $reviewStat) {
                        if ($reviewStat["stelle"] == $stars) {
                            $reviewCount = $reviewStat["numeroRecensioni"];
                            break;
                        }
                    }
                    $percentage = ($totalReviews > 0) ? ($reviewCount / $totalReviews) * 100 : 0;
                    ?>
                    
                    <div class="d-flex align-items-center mb-2">
                        <span class="me-2"><?php echo $stars ?> stelle</span>
                        <div class="progress flex-grow-1">
                            <div class="progress-bar bg-warning" style="width: <?php echo $percentage ?>%;"></div>
                        </div>
                        
                        <span class="ms-2">(<?php echo $reviewCount ?>)</span>
                    </div>
                <?php endforeach; ?>

            </div>
            <div class="col-12 mt-3">
                <div class="d-flex justify-content-md-end justify-content-center">
                    <button class="btn btn-link text-decoration-none fs-5" id="toggle-reviews-btn" style="color:#000070">
                        Visualizza recensioni 
                        <i class="bi bi-chevron-down" id="toggle-icon"></i>
                    </button>
                </div>
                <hr>
                <div id="reviews-container" class="d-none">
                    <?php if (empty($templateParams["reviews"])): ?>
                        <p class="text-muted">Nessuna recensione disponibile</p>
                    <?php else: ?>
                        <?php foreach ($templateParams["reviews"] as $review): ?>
                            <div class="card my-3 p-3 shadow-sm">
                                <!-- Review Info -->
                                <div class="row align-items-center">
                                    <div class="col-12">
                                        <div class = "d-flex flex-column flex-md-row">
                                            <span class="fs-5">ID Recensione: <span class="fw-semibold"><?php echo $review["IDrecensione"] ?></span></span>
                                            <span class="fs-5 mx-md-5">Cliente: <span class="fw-semibold"><?php echo $review["Cliente"] ?></span></span>
                                            <span class="fs-5 me-md-4 text-warning"><?php echo getStars($review["stelle"]) ?> 
                                                <span class="fs-5 text-dark">(<?php echo $review["stelle"] ?>)</span>
                                            </span>
                                        </div>
                                        <hr>
                                        <div class="card-body">
                                            <h4>Descrizione:</h4>
                                            <span class="mt-3"><?php echo $review["Testo"] ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
    </div>
</div>






<?php $prodotto = $templateParams["prodotto"];?>
<div class="row d-flex justify-content-center">
        <div class = "col-9 border rounded shadow bg-light p-4">
            <div class="row d-flex align-items-stretch">
                
                <!-- Immagini  -->
                <div class="col-md-6">
                    <div id="productCarousel" class="carousel slide p-2" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php foreach ($templateParams["immagini"] as $img): ?>
                                <?php if ($img["Icona"] == 'Y'):?>
                                    <div class="carousel-item active">
                                        <img src="<?php echo $img["PercorsoImg"]?>" class="d-block img-fluid" alt="<?php echo $img["PercorsoImg"] ?>">
                                    </div>
                                <?php else : ?>
                                <div class="carousel-item">
                                    <img src="<?php echo $img["PercorsoImg"]?>" class="d-block img-fluid" alt="<?php echo $img["PercorsoImg"] ?>">
                                </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
                
                
                <!-- Descrizione Prodotto-->
                <div class="col-md-6 h-100">
                    <div class="p-4">
                        <span class="fw-bold fs-2 me-4"><?php echo $prodotto["Nome"]?> </span>
                        <?php if($prodotto["InWishlist"] == "true"): ?>
                            <i class="bi bi-heart-fill text-danger fs-2" data-id="<?php echo htmlspecialchars($prodotto["CodiceProdotto"]); ?>" style="display:inline-block;"></i>
                            <i class="bi bi-heart fs-2" data-id="<?php echo htmlspecialchars($prodotto["CodiceProdotto"]); ?>" style="display:none;"></i>
                        <?php else: ?>
                            <i class="bi bi-heart-fill text-danger fs-2" data-id="<?php echo htmlspecialchars($prodotto["CodiceProdotto"]); ?>" style="display:none;"></i>
                            <i class="bi bi-heart  fs-2" data-id="<?php echo htmlspecialchars($prodotto["CodiceProdotto"]); ?>" style="display:inline-block;"></i>
                        <?php endif; ?>

                        <p class="fs-5 text-muted mt-2"><?php echo $prodotto["Prezzo"] ?> €</p>
                        <div class="mb-3">
                            <span class="text-warning"><?php echo getStars((int)$prodotto["ValutazioneMedia"]) ?></span>
                            <span><?php echo $prodotto["NumeroRecensioni"]?></span>
                        </div>
                        <p><?php echo $prodotto["Descrizione"]?></p>
                        <p><strong>Disponibilità:</strong> <span class="text-success"><?php echo $prodotto["Disponibilita"]?></span></p>
                        <div class="d-flex align-items-center mb-3">
                            <label for="quantity" class="me-2">Quantità:</label>
                            <input type="number" id="quantity" class="form-control w-25" min="1" value="1">
                        </div>
                        <button id="addToCartButton" class="btn btn-primary w-100 " data-id="<?php echo htmlspecialchars($prodotto["CodiceProdotto"]); ?>" >Aggiungi al carrello</button>
                    </div>
                </div>
                
            </div>

            <!-- Tabella con informazioni del prodotto -->
            <div class="row mt-5">
                <div class="col-12">
                    <h3 class="mb-3">Specifiche Prodotto</h3>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Materiale</th>
                                <td><?php echo $prodotto["Materiale"]?></td>
                            </tr>
                            <tr>
                                <th>Colore</th>
                                <td>
                                    <?php 
                                        $colors = [];
                                        foreach ($templateParams["colori"] as $colore) {
                                            $colors[] = $colore["NomeColore"];
                                        }
                                        echo implode(", ", $colors);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Largezza</th>
                                <td><?php echo $prodotto["Larghezza"]?></td>
                            </tr>
                            <tr>
                                <th>Altezza</th>
                                <td><?php echo $prodotto["Altezza"]?></td>
                            </tr>
                            <tr>
                                <th>Profondità</th>
                                <td><?php echo $prodotto["Profondita"]?></td>
                            </tr>
                            <tr>
                                <th>Peso</th>
                                <td><?php echo $prodotto["Peso"]?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Sezione Recensioni del Prodotto -->
            <div class="row mt-5">
                <div class="col-12 ">
                    <h3 class="mb-3">Recensioni Prodotto</h3>
                    <div class="d-flex align-items-center mb-3">
                        <div>
                            <span class="text-warning fs-4">&#9733;&#9733;&#9733;&#9733;&#9734;</span>
                        </div>
                        <div class="ms-3">
                            <strong>4</strong> su 5
                        </div>
                    </div>

                    <div class="d-flex align-items-center">
                        <span class="me-2">5 stelle</span>
                        <div class="progress flex-grow-1">
                            <div class="progress-bar bg-warning" style="width: 80%;"></div>
                        </div>
                        <span class="ms-2">(24)</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="me-2">4 stelle</span>
                        <div class="progress flex-grow-1">
                            <div class="progress-bar bg-warning" style="width: 16%;"></div>
                        </div>
                        <span class="ms-2">(8)</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="me-2">3 stelle</span>
                        <div class="progress flex-grow-1">
                            <div class="progress-bar bg-warning" style="width: 2%;"></div>
                        </div>
                        <span class="ms-2">(1)</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="me-2">2 stelle</span>
                        <div class="progress flex-grow-1">
                            <div class="progress-bar bg-warning" style="width: 0%;"></div>
                        </div>
                        <span class="ms-2">(0)</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="me-2">1 stella</span>
                        <div class="progress flex-grow-1">
                            <div class="progress-bar bg-warning" style="width: 8%;"></div>
                        </div>
                        <span class="ms-2">(4)</span>
                    </div>   
                </div>
            </div>
        </div>
</div>


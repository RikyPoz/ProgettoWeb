<?php foreach ($templateParams["prodotto"] as $prodotto):?>
<div class="row d-flex justify-content-center">
        <div class = "col-9 border rounded shadow bg-light p-4">
            <div class="row d-flex align-items-stretch">
                
                <!-- Immagini  -->
                <div class="col-md-6">
                    <div id="productCarousel" class="carousel slide p-2" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="upload/poz/img1.png" class="d-block img-fluid" alt="Prodotto 1">
                            </div>
                            <?php foreach ($templateParams["immagini"] as $img): ?>
                            <div class="carousel-item">
                                <img src="<?php echo $img["img"] ?>" class="d-block img-fluid" alt="<?php echo $img["img"] ?>">
                            </div>
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
                        <h2 class="fw-bold"><?php echo $prodotto["nome"]?> </h2>
                        <span class="fs-5 text-muted "><?php echo $prodotto["prezzo"] ?> €</span>
                        <div class="mb-3">
                            <span class="text-warning">&#9733;&#9733;&#9733;&#9733;&#9734;</span>
                            <span><?php echo $prodotto["recensioniTotali"]?></span>
                        </div>
                        <p><?php echo $prodotto["descrizione"]?></p>
                        <p><strong>Disponibilità:</strong> <span class="text-success"><?php echo $prodotto["disponibilità"]?></span></p>
                        <div class="d-flex align-items-center mb-3">
                            <label for="quantity" class="me-2">Quantità:</label>
                            <input type="number" id="quantity" class="form-control w-25" min="1" value="1">
                        </div>
                        <button class="btn btn-primary w-100">Aggiungi al carrello</button>
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
                                <td>Legno</td>
                            </tr>
                            <tr>
                                <th>Colore</th>
                                <td>Marrone</td>
                            </tr>
                            <tr>
                                <th>Lunghezza</th>
                                <td>120 cm</td>
                            </tr>
                            <tr>
                                <th>Altezza</th>
                                <td>75 cm</td>
                            </tr>
                            <tr>
                                <th>Larghezza</th>
                                <td>60 cm</td>
                            </tr>
                            <tr>
                                <th>Peso</th>
                                <td>15 kg</td>
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
<?php endforeach; ?>

<div class = "row justify-content-center my-5" style="min-height: 70vh">
  <div class="col-md-10 col-12 rounded shadow  p-4">
    <!-- Titolo e filtro -->
    <div class="d-flex justify-content-center justify-content-md-start">
      <h1 class="fw-bold "style = "color:#000070">I miei Ordini</h1>
    </div>

    <!--Order List-->
    <?php if (!empty($templateParams["ordini"])): ?>
      <div id="orders-list ">
        <?php foreach($templateParams["ordini"] as $ordine): ?>
          <!--Single Order-->
          <div class=" my-5 border bg-light rounded shadow-sm">
              <!--Order Info-->
              <div class = "d-flex flex-column flex-md-row ms-3 justify-content-md-around ms-md-0 my-4">
                  <span class ="fs-4">ID Ordine: <span class = "fw-semibold"><?php echo $ordine["IDordine"] ?></span></span> 
                  <span class ="fs-4">Costo Totale: <span class = "fw-semibold"><?php echo $ordine["CostoTotale"] ?></span>€</span> 
                  <span class ="fs-4">Data Ordine: <span class = "fw-semibold"><?php echo $ordine["Data"] ?></span></span>
              </div>
              <!--Separator-->
              <hr class = "mb-4">
              <!--Product List-->
              <div class = "px-4">
                <?php foreach ($ordine["prodotti"] as $prodotto): ?>
                <!--Single Product -->
                <div class = " row justify-content-center align-items-center border rounded-3 shadow-sm bg-white p-3 mb-3 ">
                    <div class = "col-md-2 col-6 ">
                        <img src="<?php echo $prodotto["PercorsoImg"] ?>" alt="<?php echo $prodotto["Nome"] ?>" class="img-fluid">
                    </div>
                    <div class = "col-md-10 col-12 d-flex justify-content-center justify-content-md-start ps-md-5">
                      <div class ="flex-column">
                        <div class = "d-flex flex-column align-items-center align-items-md-start mb-4">
                          <h2 style = "color:#000070"><?php echo $prodotto["Nome"] ?> </h2>
                          <span class="fs-4 ">Quantità : <span class = "fw-semibold"><?php echo $prodotto["Quantita"] ?></span></span>
                          <span class="fs-4 ">Prezzo Pagato: <span class = "fw-semibold"><?php echo $prodotto["PrezzoPagato"] ?> €</span></span>
                        </div>
                        <?php if($prodotto["Rimosso"] == 'N'):?>
                          <div>
                            <a href="singleProduct.php?id=<?php echo $prodotto["CodiceProdotto"]?>" class="btn border-black rounded-pill me-1"><i class="bi bi-eye me-2"></i>Visualizza </a>
                            <a href="review.php?id=<?php echo $prodotto["CodiceProdotto"]?>" class="btn border-black  rounded-pill"><i class="bi bi-pen me-2"></i>Recensisci </a>
                          </div>
                        <?php else: ?>
                            <span class = "fs-5 text-muted">(Questo prodotto è stato rimosso dal venditore)</span>
                        <?php endif;?>
                      </div>
                    </div>
                </div>
                <?php endforeach; ?>
              </div>
              <!--Button-->
              <div class="d-flex justify-content-md-end justify-content-center p-3">
                  <button 
                      type="button" 
                      class="btn btn-lg" 
                      id="traccia-<?php echo $ordine["IDordine"]; ?>"
                      data-idOrdine="<?php echo $ordine["IDordine"]; ?>"
                      data-codiceStato="<?php echo $ordine["CodiceStato"]; ?>"
                      data-giorniSpedizione="<?php echo $ordine["GiorniSpedizione"]; ?>"
                      style="background-color: #000060; color: #FFFFFF">
                      Traccia il mio pacco
                  </button>
              </div>

          </div>
        <?php endforeach; ?>
      </div>
      <?php else:?>
        <div class="d-flex justify-content-center align-items-center" style="height: 70vh;">
          <div class="text-center">
              <img src="upload/noOrder.png" alt="nessun ordine" class="img-fluid">
              <h3 class="text-muted mt-4">Nessun Ordine</h3>
              <p>Non hai effettuato nessun ordine</p>
          </div>
        </div>
      <?php endif; ?>
  </div>
</div>

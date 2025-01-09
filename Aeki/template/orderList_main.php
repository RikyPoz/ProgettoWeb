<div class = "row justify-content-center">
  <div class="col-md-10 col-12 mt-4">
    <!-- Titolo e filtro -->
    <div class="d-flex flex-column flex-md-row align-items-center mb-4">
      <h1>I miei Ordini</h1>
      <div class = "d-inline-flex ms-md-5">
        <select id="order-sort" class="form-select">
          <option value = "Date" >Data Ordine</option>
          <option value = "Price" >Costo Totale</option>
        </select>
      </div>
    </div>

    <!--Order List-->
    <?php if (!empty($templateParams["prodotti"])): ?>
      <div id="orders-list ">
        <?php foreach($templateParams["ordini"] as $ordine): ?>
          <!--Single Order-->
          <div class=" my-3 border rounded shadow">
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
                <div class = " row justify-content-center align-items-center border rounded shadow-sm p-3 mb-3 ">
                    <div class = "col-md-2 col-6 ">
                        <img src="<?php echo $prodotto["PercorsoImg"] ?>" alt="img" class="img-fluid">
                    </div>
                    <div class = "col-md-10 col-12 flex-column  ps-md-5">
                        <div class = "d-flex flex-column">
                          <h2><?php echo $prodotto["Nome"] ?> </h2>
                          <span class="fs-4 me-4">Quantità : <span class = "fw-semibold"><?php echo $prodotto["Quantita"] ?></span></span>
                          <span class="fs-4 ">Prezzo Pagato: <span class = "fw-semibold"><?php echo $prodotto["PrezzoPagato"] ?> €</span></span>
                        </div>
                        <div class = "mt-4">
                          <a href="singleProduct.php?id=<?php echo $prodotto["CodiceProdotto"]?>" class="btn btn-primary">Visualizza articolo</a>
                          <a href="review.php?id=<?php echo $prodotto["CodiceProdotto"]?>" class="btn btn-primary">Recensisci Articolo</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
              </div>
              <!--Button-->
              <div class = "d-flex justify-content-md-end justify-content-center p-3 ">
                <button type="button" class="btn border shadow-sm btn-lg">Traccia il mio pacco</button>
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

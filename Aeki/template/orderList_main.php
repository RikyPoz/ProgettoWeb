<div class = "row justify-content-center">
  <div class="col-10 mt-4">
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
    <div id="orders-list ">
      <?php foreach($templateParams["ordini"] as $ordine): ?>
        <!--Single Order-->
        <div class=" my-3 border rounded shadow">
            <!--Order Info-->
            <div class = "d-flex flex-column flex-md-row ms-3 justify-content-md-around ms-md-0 my-4">
                <span class ="fs-5">ID Ordine: <span class = "fw-semibold"><?php echo $ordine["idOrdine"] ?></span></span> 
                <span class ="fs-5">Costo Totale: <span class = "fw-semibold"><?php echo $ordine["costoTotale"] ?></span></span> 
                <span class ="fs-5">Data Ordine: <span class = "fw-semibold"><?php echo $ordine["dataOrdine"] ?></span></span>
            </div>
            <!--Separator-->
            <hr class = "mb-4">
            <!--Product List-->
            <div class = "px-4">
              <?php foreach ($ordine["prodotti"] as $prodotto): ?>
                <!--Single Product -->
                  <div class = " row justify-content-center bg-light border rounded p-3 mb-3 ">
                      <div class = "col-md-2 col-6 ">
                          <img src="<?php echo $prodotto["PercorsoImg"] ?>" alt="img" class="img-fluid">
                      </div>
                      <div class = "col-md-10 col-12 flex-column  ps-md-5">
                          <div>
                            <h2 class="fw-semibold fs-4"><?php echo $prodotto["Nome"] ?> </h2>
                            <span class="fs-5 text-muted "><?php echo $prodotto["Prezzo"] ?> €</span>
                          </div>
                          <div class = "mt-4">
                            <a href="singleProduct.php?id=123" class="btn btn-primary btn-sm">Visualizza articolo</a>
                            <a href="reviewProduct.php?id=123" class="btn btn-primary btn-sm">Recensisci Articolo</a>
                          </div>
                      </div>
                  </div>
              <?php endforeach; ?>
            </div>
            <!--Button-->
            <div class = "d-flex justify-content-md-end justify-content-center p-3 ">
              <button type="button" class="btn btn-light btn-lg">Traccia il mio pacco</button>
            </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

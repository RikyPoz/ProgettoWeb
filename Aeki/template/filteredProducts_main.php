<?php
$sliderMin = 0;
$sliderMax = 100;
?>

<div class="row d-flex justify-content-center mt-5">
  <div class = "col-md-10 col-12 border rounded shadow bg-light p-4">
    <div class="row d-flex align-items-stretch">
      <!-- Colore -->
      <div class="col-12 col-md-4" data-group="colore">
        <h5 class="fw-semibold mb-3">Colore</h5>
        <div class="row row-cols-2">
          <?php
          foreach ($templateParams["colors"] as $color) {
            echo "<div class='col'>
                    <div class='form-check'>
                      <input class='form-check-input' type='checkbox' id='{$color['NomeColore']}'>
                      <label class='form-check-label' for='{$color['NomeColore']}'>" . ucfirst($color["NomeColore"]) . "</label>
                    </div>
                  </div>";
          }
          ?>
        </div>
      </div>

      <!-- Prezzo -->
      <div class="col-12 col-md-4">
        <h5 class="fw-semibold mb-3">Prezzo</h5>
        <div class="mb-3">
          <!-- Valori selezionati -->
          <div class="d-flex justify-content-between small mb-2">
            <span id="displayMinPrice">€ -</span>
            <span id="displayMaxPrice">€ -</span>
          </div>

          <!-- Slider -->
          <input type="range" class="form-range" id="minPriceInput" min="<?php echo $sliderMin; ?>" max="<?php echo $sliderMax; ?>" value="<?php echo $sliderMin; ?>">
          <input type="range" class="form-range" id="maxPriceInput" min="<?php echo $sliderMin; ?>" max="<?php echo $sliderMax; ?>" value="<?php echo $sliderMax; ?>">
        </div>
      </div>

      <!-- Recensioni -->
      <div class="col-12 col-md-4">
        <h5 class="fw-semibold mb-3">Recensioni</h5>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="fiveStars">
          <label class="form-check-label" for="fiveStars">5</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="fourStars">
          <label class="form-check-label" for="fourStars">4+</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="threeStars">
          <label class="form-check-label" for="threeStars">3+</label>
        </div>
      </div>

      <div class="text-end mt-3">
        <button class="btn" style="background-color:#000060;color:#FFFFFF"id ="filterButton"><i class="bi bi-filter"></i> Filtra</button>
      </div>
    </div>
  </div>
</div>


<div class="row d-flex justify-content-center mb-5">
  <div class = "col-md-10 col-12 border rounded shadow bg-light p-4">
    <div class="row d-flex align-items-stretch">
      <!-- Lista Prodotti -->
      <h1 class="fw-semibold mb-3">
        <span id="filterType" data="<?php echo $templateParams["tipoSelezione"]; ?>"><?php echo $templateParams["nomeSelezione"]; ?></span>
        <span id="productCount" class="text-muted"></span>
      </h1>
      <div class="row g-4" id="productsContainer"></div>
    </div>
  </div>
</div>
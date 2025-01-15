<?php
$sliderMin = 0;
$sliderMax = 100;
?>

<div class="row d-flex justify-content-center mt-5">
  <div class = "col-md-10 col-12 border rounded shadow bg-light p-4">
    <div class="d-flex justify-content-md-start justify-content-center">
      <button class="btn btn-link text-decoration-none fs-5" id="toggle-filter-btn" style="color:#000070">
          Visualizza Filtri 
          <span class="bi bi-chevron-down" id="toggle-icon"></span>
      </button>
    </div>
    <hr>
    <div class="row d-flex align-items-stretch d-none" id="filter-container">
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
            <label id="displayMinPrice" for="minPriceInput">€ -</label>
            <label id="displayMaxPrice" for="maxPriceInput">€ -</label>
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
        <button class="btn" style="background-color:#000060;color:#FFFFFF" id ="filterButton"><span class="bi bi-filter"></span> Filtra</button>
      </div>
    </div>
  </div>
</div>


<div class="row d-flex justify-content-center mb-5">
  <div class = "col-md-10 col-12 border rounded shadow bg-light p-4">
    <div class="row d-flex align-items-stretch justify-content-center">
      <!-- Lista Prodotti -->
      <h2 class="fw-semibold mb-3" style="color:#000070">
        <span id="filterType" data-id="<?php echo $templateParams["tipoSelezione"]; ?>"><?php echo $templateParams["nomeSelezione"]; ?></span>
        <span id="productCount" class="text-muted"></span>
      </h2>
      <div class="row g-4" id="productsContainer"></div>
    </div>
  </div>
</div>
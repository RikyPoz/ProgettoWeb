<?php
$minPrice = min(array_column($templateParams["lista_prodotti"], 'Prezzo'));
$maxPrice = max(array_column($templateParams["lista_prodotti"], 'Prezzo'));
?>

<div class="row d-flex justify-content-center">
  <div class = "col-9 border rounded shadow bg-light p-4">
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

          <div class="d-flex justify-content-between small mb-2">
            <span id="selectedMinPrice">€<?php echo number_format($minPrice, 2); ?></span>
            <span id="selectedMaxPrice">€<?php echo number_format($maxPrice, 2); ?></span>
          </div>

          <input type="range" class="form-range" id="minPrice" min="<?php echo log($minPrice); ?>" max="<?php echo log($maxPrice); ?>" step="0.01" value="<?php echo log($minPrice); ?>">
          <input type="range" class="form-range" id="maxPrice" min="<?php echo log($minPrice); ?>" max="<?php echo log($maxPrice); ?>" step="0.01" value="<?php echo log($maxPrice); ?>">
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
        <button class="btn btn-primary" id ="filterButton"><i class="bi bi-filter"></i> Filtra</button>
      </div>
    </div>
  </div>
</div>


<div class="row d-flex justify-content-center">
  <div class = "col-9 border rounded shadow bg-light p-4">
    <div class="row d-flex align-items-stretch">
      <!-- Lista Prodotti -->
      <div class="row g-4" id="productsContainer"></div>
    </div>
  </div>
</div>

<script>
  const minPriceInput = document.getElementById('minPrice');
  const maxPriceInput = document.getElementById('maxPrice');
  const selectedMinPrice = document.getElementById('selectedMinPrice');
  const selectedMaxPrice = document.getElementById('selectedMaxPrice');
  const rangeFill = document.getElementById('rangeFill');
  
  function updateRange() {
    const minLogValue = parseFloat(minPriceInput.value);
    const maxLogValue = parseFloat(maxPriceInput.value);

    if (minLogValue > maxLogValue) {
      minPriceInput.value = maxLogValue;
    }

    const minLinearValue = Math.exp(minPriceInput.value).toFixed(2);
    const maxLinearValue = Math.exp(maxPriceInput.value).toFixed(2);

    selectedMinPrice.textContent = `€${minLinearValue}`;
    selectedMaxPrice.textContent = `€${maxLinearValue}`;
  }

  minPriceInput.addEventListener('input', updateRange);
  maxPriceInput.addEventListener('input', updateRange);
  updateRange();
</script>
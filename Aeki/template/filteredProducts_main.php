   

  <!--
  <script>
    // JavaScript per aggiornare la barra riempita tra i due cursori
    const minPrice = document.getElementById('minPrice');
    const maxPrice = document.getElementById('maxPrice');
    const rangeFill = document.getElementById('rangeFill');

    function updateRange() {
      const min = parseInt(minPrice.value);
      const max = parseInt(maxPrice.value);
      const rangeMin = parseInt(minPrice.min);
      const rangeMax = parseInt(maxPrice.max);
      const left = ((min - rangeMin) / (rangeMax - rangeMin)) * 100;
      const width = ((max - min) / (rangeMax - rangeMin)) * 100;
      rangeFill.style.left = left + '%';
      rangeFill.style.width = width + '%';
    }

    minPrice.addEventListener('input', updateRange);
    maxPrice.addEventListener('input', updateRange);
    updateRange();
  </script>
-->


<div class="row d-flex justify-content-center">
  <div class = "col-9 border rounded shadow bg-light p-4">
    <div class="row d-flex align-items-stretch">
      <!-- Colore -->
      <div class="col-12 col-md-4">
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
          <!-- Doppio cursore -->
          <input type="range" class="form-range" id="minPrice" min="0" max="1000" step="10">
          <input type="range" class="form-range" id="maxPrice" min="0" max="1000" step="10">
          <div class="d-flex justify-content-between small">
            <span>€0</span>
            <span>€1000</span>
          </div>
        </div>
        <div class="range-bar mb-3">
          <div id="rangeFill" class="range-fill" style="left: 10%; width: 50%;"></div>
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
        <button class="btn btn-success"><i class="bi bi-filter"></i> Filtra</button>
      </div>
    </div>
  </div>
</div>


<div class="row d-flex justify-content-center">
  <div class = "col-9 border rounded shadow bg-light p-4">
    <div class="row d-flex align-items-stretch">
      <!-- Lista Prodotti -->
      <div class="row g-4">
        <?php
          foreach ($templateParams["lista_prodotti"] as $product) {
            echo "<div class='col-6 col-md-4 col-lg-3'>
                    <div class='card text-center shadow-sm border-0'>
                      <img src='{$product['PercorsoImg']}' class='card-img-top rounded-3' alt='Prodotto'>
                      <div class='card-body'>
                        <h6 class='card-title text-dark fw-semibold'>{$product['Nome']}</h6>
                        <p class='text-success fw-bold'>€" . number_format($product['Prezzo'], 2) . "</p>
                        <div class='d-flex justify-content-center align-items-center'>
                          <span class='text-warning fs-4'>" . getStars($product["ValutazioneMedia"]) . "</span>
                          <span class='text-muted ms-1 small'>({$product['NumeroRecensioni']})</span>
                        </div>
                      </div>
                    </div>
                  </div>";
          }
        ?>
      </div>
    </div>
  </div>
</div>
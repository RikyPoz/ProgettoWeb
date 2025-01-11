<!DOCTYPE html>
<html lang="it">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
  
    <!-- Icone Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <title><?php echo $templateParams["titolo"]; ?></title>
    <link rel="stylesheet" type="text/css" href="./css/style.css" />
</head>
<body>
    
<?php 
if (isset($_SESSION['user_id'])): 
    $user_id = $_SESSION['user_id'];
    $userType = $dbh->userType($user_id);
else:
    $userType = "Cliente";
endif; 
?>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-light shadow">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class = "d-flex align-items-center">
                <!-- Hamburger Menu -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- Brand Logo -->
                <a class="navbar-brand" href="homePage.php"><img src="upload/logo.png" alt="Logo" width="60" height="60" class="d-inline-block align-text-top"></a>
            </div>

            <!-- Search Bar -->
            <form class="d-flex mx-auto" role="search" style="width: 50%;" action="filteredProducts.php" method="get">
                <input class="form-control me-2" type="search" name="search" placeholder="Cerca..." aria-label="Search" required>
                <button class="btn btn-outline-secondary" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </form>

            <div class="collapse navbar-collapse" id="navbarNav">

                <!-- Icons Section -->
                <ul class="navbar-nav ms-auto d-flex justify-content-around align-items-center">
                    <li class="nav-item d-flex flex-column align-items-center">
                        <?php if (isset($_SESSION['user_id'])): ?>
                        <?php
                            $user_id = $_SESSION['user_id'];
                            $unread_count = $dbh->getNumeroNotifiche($user_id); 
                        ?>
                        <div class="dropdown">
                            <button class="btn btn-light text-center" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person" style="font-size: 1.5rem;"></i>
                                <!-- Punto rosso per notifiche non lette -->
                                <?php if ($unread_count > 0): ?>
                                    <span class="badge bg-danger" style="position: absolute; top: -5px; right: -5px; font-size: 0.8rem;"><?php echo $unread_count; ?></span>
                                <?php endif; ?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow rounded" aria-labelledby="profileDropdown">
                                <li><a class="dropdown-item" href="profile.php"><i class="bi bi-person-circle me-2"></i>Profilo</a></li>
                                <li><a class="dropdown-item" href="orderList.php"><i class="bi bi-list-check me-2"></i>Ordini</a></li>
                                <li><a class="dropdown-item text-danger logout-button" href="#"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                            </ul>
                        </div>
                        <?php else: ?>
                        <a href="login.php" class="btn btn-light text-center">
                            <i class="bi bi-person" style="font-size: 1.5rem;"></i>
                        </a>
                        <?php endif; ?>
                        <span>Profilo</span>
                    </li>
                    <?php if($userType === "Cliente"): ?>
                    <li class="nav-item d-flex flex-column align-items-center mx-3">
                        <a href="whishlist.php" class="btn btn-light text-center">
                            <i class="bi bi-house-heart" style="font-size: 1.5rem;"></i>
                        </a>
                        <span>Preferiti</span>
                    </li>
                    <li class="nav-item d-flex flex-column align-items-center">
                        <a href="shoppingCart.php" class="btn btn-light text-center">
                            <i class="bi bi-cart" style="font-size: 1.5rem;"></i>
                        </a>
                        <span>Carrello</span>
                    </li>
                    <?php else: ?>
                    <li class="nav-item d-flex flex-column align-items-center mx-3">
                        <a href="seller.php" class="btn btn-light text-center">
                            <i class="bi bi-briefcase" style="font-size: 1.5rem;"></i>
                        </a>
                        <span>Hub</span>
                    </li>

                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Main -->
    <main>
        <?php
            if(isset($templateParams["nome"])){
                require($templateParams["nome"]);
            }
        ?>
    </main>
    <?php if($userType === "Cliente"): ?>
    <!-- Footer -->
    <footer style="background-color: #FFFFFF; color: #000000; padding: 40px 20px;">
      <div style="max-width: 1200px; margin: auto; display: flex; flex-wrap: wrap; justify-content: space-between;">
          <!-- Informazioni aziendali -->
          <div style="flex: 1 1 300px; margin-bottom: 20px;">
              <h3 style="color: #000000; margin-bottom: 10px;">AEKI</h3>
              <p>Via dell'Universita, 18 - 47521 Cesena FC, Italia</p>
              <p>Email: supporto@aeki.it</p>
              <p>Tel: +39 123 456 789</p>
          </div>
      
          <!-- Navigazione utile -->
          <div style="flex: 1 1 200px; margin-bottom: 20px; text-align: center;"> <!-- Allineamento centrato -->
              <h4 style="color: #000000; margin-bottom: 10px;">Navigazione</h4>
              <ul style="list-style: none; padding: 0; text-align: center; display: inline-block;"> <!-- Centrare contenuto -->
                  <li><a href="homePage.php" style="color: #4CAF50; text-decoration: none;">Home</a></li>
                  <li><a href="profile.php" style="color: #4CAF50; text-decoration: none;">Profilo personale</a></li>
                  <li><a href="orderList.php" style="color: #4CAF50; text-decoration: none;">Ordini</a></li>
                  <li><a href="whishlist.php" style="color: #4CAF50; text-decoration: none;">Preferiti</a></li>
              </ul>
          </div>
      
          <!-- Social media e metodi di pagamento -->
          <div style="flex: 1 1 300px; margin-bottom: 20px; text-align: center;">
              <h4 style="color: #000000; margin-bottom: 10px;">Seguici su</h4>
              <a style="margin-right: 10px;"><img src="upload/footer/facebook.png" alt="Facebook" width="30"></a>
              <a style="margin-right: 10px;"><img src="upload/footer/instagram.png" alt="Instagram" width="30"></a>
              <a style="margin-right: 10px;"><img src="upload/footer/x.png" alt="X" width="30"></a>
              <h4 style="color: #000000; margin-top: 20px;">Pagamenti Accettati</h4>
              <img src="upload/footer/visa.png" alt="Visa" width="50" style="margin-right: 10px;">
              <img src="upload/footer/mastercard.png" alt="Mastercard" width="50" style="margin-right: 10px;">
              <img src="upload/footer/paypal.png" alt="PayPal" width="50">
          </div>
      </div>
      
      <!-- Copyright -->
      <div style="text-align: center; margin-top: 20px; border-top: 1px solid #555; padding-top: 10px; font-size: 14px;">
          © 2025 [AEKI]. Tutti i diritti non riservati.
      </div>
    </footer>
    <?php endif; ?>

  <?php
    if(isset($templateParams["js"])):
        foreach($templateParams["js"] as $script):
    ?>
        <script src="<?php echo $script; ?>"></script>
    <?php
        endforeach;
    endif;
    ?>
</body>

</html>

<script src="js/logout.js"></script>
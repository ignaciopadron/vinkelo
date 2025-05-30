<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Vinkelo - Distribuidor Vinos</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link 
    rel="stylesheet" 
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link 
    rel="stylesheet" 
    href="https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>
<body>
  <!--==================== HEADER ====================-->
  <header class="sticky-top shadow-sm bg-white">
    <div class="container py-2">
      <div class="row align-items-center">

        <!-- Logo y buscador -->
        <div class="col-lg-4 d-flex align-items-center">
          <a href="<?= BASE_URL ?>" class="mb-0 mr-4" 
             style="text-decoration: none;">
             <img 
             src="<?= BASE_URL ?>assets/img/logo_vinnkelo_vectorizado.svg" 
             alt="Logo Vinkelo" 
             style="width: 150px; height: auto;"
             class="img-fluid">
          </a>
          <!-- Buscador -->
          <form class="d-none d-md-flex flex-grow-1 mr3" action="<?= BASE_URL ?>search" method="GET">
            <div class="input-group" >
              <input 
                type="text" 
                class="form-control"
                name="q"
                placeholder="Buscar..."
                aria-label="Buscar">
              <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit">
                  <i class='bx bx-search'></i>
                </button>
              </div>
            </div>
          </form>
        </div>

        <!-- Botones Iniciar Sesión, Registrarse y Carrito -->
        <div class="col-lg-8 text-right d-flex justify-content-end align-items-center">
          <!-- Buscador móvil -->
          <form class="d-md-none mr-3" style="width: 150px;" action="<?= BASE_URL ?>search" method="GET">
            <div class="input-group">
              <input 
                type="text" 
                class="form-control" 
                name="q"
                placeholder="Buscar..."
                aria-label="Buscar">
              <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit">
                  <i class='bx bx-search'></i>
                </button>
              </div>
            </div>
          </form>

          <?php if(isLoggedIn()) : ?>
            <!-- Usuario logueado -->
            <div class="d-flex align-items-center mr-3 user-logged">
                <i class='bx bx-user-circle h4 mb-0 mr-2 text-secondary'></i>
                <span class="mr-3"><?= htmlspecialchars($_SESSION['username']) ?></span>
                <a href="<?= BASE_URL ?>logout" class="btn btn-outline-dark">Salir</a>
            </div>
          <?php else : ?>
            <!-- Usuario no logueado -->
            <a href="<?= BASE_URL ?>login" class="btn btn-outline-dark mr-2">Iniciar Sesión</a>
            <a href="<?= BASE_URL ?>register" class="btn btn-dark mr-3">Registrarse</a>
          <?php endif; ?>

          <a href="#" class="text-dark h4 mb-0">
            <i class='bx bx-cart'></i>
          </a>
        </div>

      </div>
    </div>
    <!-- Menú de navegación principal -->
    <nav class="navbar navbar-expand-lg navbar-light border-top" style="background-color: #f0f4f8;">
      <div class="container">

        <!-- Botón toggle (para mobile) -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" 
                data-target="#mainNav" aria-controls="mainNav" 
                aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Enlaces de navegación -->
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav w-100 justify-content-between">
            <li class="nav-item">
              <a class="nav-link" href="<?= BASE_URL ?>">Home</a>
            </li>

            <!-- Menú desplegable Vinos -->
            <li class="nav-item dropdown dropdown-vinos">
              <a class="nav-link dropdown-toggle" href="#" id="vinosDropdown" 
                role="button" data-toggle="dropdown" aria-haspopup="true" 
                aria-expanded="false">
                Vinos
              </a>
              <div class="dropdown-menu dropdown-menu-vinos" aria-labelledby="vinosDropdown">
                <div class="dropdown-columns-container">
                  <!-- Tipos de Vino -->
                  <div class="dropdown-col">
                    <h6 class="dropdown-category-title">Tipos de Vino</h6>
                    <a class="dropdown-item dropdown-wine-item" href="<?= BASE_URL ?>wines?filtro=4&id=1">Tinto</a>
                    <a class="dropdown-item dropdown-wine-item" href="<?= BASE_URL ?>wines?filtro=4&id=2">Blanco</a>
                    <a class="dropdown-item dropdown-wine-item" href="<?= BASE_URL ?>wines?filtro=4&id=3">Rosado</a>
                    <a class="dropdown-item dropdown-wine-item" href="<?= BASE_URL ?>wines?filtro=4&id=4">Dulce</a>
                    <a class="dropdown-item dropdown-wine-item" href="<?= BASE_URL ?>wines?filtro=4&id=5">Semi-dulce</a>
                    <a class="dropdown-item dropdown-wine-item" href="<?= BASE_URL ?>wines?filtro=4&id=6">Cava</a>
                    <a class="dropdown-item dropdown-wine-item" href="<?= BASE_URL ?>wines?filtro=4&id=7">Vermut</a>
                    <a class="dropdown-item dropdown-wine-item" href="<?= BASE_URL ?>wines?filtro=4&id=8">Hidromiel</a>
                  </div>
                  
                  <!-- Variedad de uva -->
                  <div class="dropdown-col">
                    <h6 class="dropdown-category-title">Variedad de uva</h6>
                    <a class="dropdown-item dropdown-wine-item" href="<?= BASE_URL ?>wines?filtro=1&id=1">Verdejo</a>
                    <a class="dropdown-item dropdown-wine-item" href="<?= BASE_URL ?>wines?filtro=1&id=2">Sauvignon Blanc</a>
                    <a class="dropdown-item dropdown-wine-item" href="<?= BASE_URL ?>wines?filtro=1&id=3">Tempranillo</a>
                    <a class="dropdown-item dropdown-wine-item" href="<?= BASE_URL ?>wines?filtro=1&id=4">Garnacha</a>
                    <a class="dropdown-item dropdown-wine-item" href="<?= BASE_URL ?>wines?filtro=1&id=5">Moscatel</a>
                    <a class="dropdown-item dropdown-wine-item" href="<?= BASE_URL ?>wines?filtro=1&id=6">Monastrell</a>
                  </div>
                  
                  <!-- Denominación de Origen -->
                  <div class="dropdown-col">
                    <h6 class="dropdown-category-title">Denominación de Origen</h6>
                    <a class="dropdown-item dropdown-wine-item" href="<?= BASE_URL ?>wines?filtro=2&id=1">La Rioja</a>
                    <a class="dropdown-item dropdown-wine-item" href="<?= BASE_URL ?>wines?filtro=2&id=2">Ribera del Duero</a>
                    <a class="dropdown-item dropdown-wine-item" href="<?= BASE_URL ?>wines?filtro=2&id=3">Jumilla</a>
                    <a class="dropdown-item dropdown-wine-item" href="<?= BASE_URL ?>wines?filtro=2&id=4">Calatayud</a>
                    <a class="dropdown-item dropdown-wine-item" href="<?= BASE_URL ?>wines?filtro=2&id=5">Pago de Vallegarcía</a>
                  </div>

                  <!-- Envejecimiento -->
                  <div class="dropdown-col">
                    <h6 class="dropdown-category-title">Envejecimiento</h6>
                    <a class="dropdown-item dropdown-wine-item" href="<?= BASE_URL ?>wines?filtro=3&id=1">Joven</a>
                    <a class="dropdown-item dropdown-wine-item" href="<?= BASE_URL ?>wines?filtro=3&id=2">Roble</a>
                    <a class="dropdown-item dropdown-wine-item" href="<?= BASE_URL ?>wines?filtro=3&id=3">Crianza</a>
                    <a class="dropdown-item dropdown-wine-item" href="<?= BASE_URL ?>wines?filtro=3&id=4">Reserva</a>
                  </div>
                </div>
              </div>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="<?= BASE_URL ?>about">Quiénes somos</a>
            </li>
            
            <li class="nav-item">
              <a class="nav-link" href="<?= BASE_URL ?>contact">Contacto</a>
            </li>
            
            <?php if(isLoggedIn() && isAdmin()) : ?>
            <li class="nav-item">
              <a class="nav-link" href="<?= BASE_URL ?>admin">Administración</a>
            </li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <!-- Contenido principal -->
  <main> 
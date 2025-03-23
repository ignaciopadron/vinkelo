<?php
require 'config.php';
require 'funciones.php';

// 1. Verificar parámetros de forma segura
$filtro = isset($_GET['filtro']) ? (int)$_GET['filtro'] : null;
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$pagina_actual = isset($_GET['page']) ? (int)$_GET['page'] : 1;


// 2. Inicializar variables con valores por defecto
$total_vinos = 0;
$vinos = [];

// 3. Añadir validación de filtro
if ($filtro && $id) {
// Configurar paginación
$resultados_por_pagina = 12; // Ajusta según necesidad
$offset = ($pagina_actual - 1) * $resultados_por_pagina;

// Obtener datos según filtro
switch ($filtro) {
    case 'variedad':
        $vinos = obtenerVinosPorVariedad($id, 12, ($pagina_actual - 1) * 12);
        $total_vinos = contarVinosPorVariedad($id);
        $titulo = "Vinos de " . obtenerNombreVariedad($id); // Función a crear
        break;
    case 'region':
        $vinos = obtenerVinosPorRegion($id, 12, ($pagina_actual - 1) * 12);
        $total_vinos = contarVinosPorRegion($id);
        $titulo = "Vinos de " . obtenerNombreRegion($id);
        break;
    case 'crianza':
        $vinos = obtenerVinosPorCrianza($id, 12, ($pagina_actual - 1) * 12);
        $total_vinos = contarVinosPorCrianza($id);
        $titulo = "Vinos de " . obtenerNombreCrianza($id);
        break;
    case 'precio':
        $vinos = obtenerVinosPorPrecio($id, 12, ($pagina_actual - 1) * 12);
        $total_vinos = contarVinosPorPrecio($id);
        $titulo = "Vinos de " . obtenerNombrePrecio($id);
        break;      
        default:
        // Manejar filtro no válido
        header("Location: vinos.php");
        exit;          
}
    // Calcular total de páginas solo si hay resultados
    $total_paginas = $total_vinos > 0 ? ceil($total_vinos / $resultados_por_pagina) : 1;
} else {
    // Mostrar todos los vinos si no hay filtro
    $vinos = obtenerTodosLosVinos(); // Necesitarías crear esta función
    $total_paginas = 1;
}
?>

<!DOCTYPE html>
<html>
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
  <link rel="stylesheet" href="style.css">
</head>
</head>
   <!--==================== HEADER ====================-->
   <header class="sticky-top shadow-sm bg-white">
    <div class="container py-2">
      <div class="row align-items-center">

        <!-- Logo y buscador -->
        <div class="col-lg-4 d-flex align-items-center">
          <a href="index.php" class="mb-0 mr-4" 
             style="text-decoration: none;">
             <img 
             src="img/logo_vinnkelo_vectorizado.svg" 
             alt="Logo Vinkelo" 
             style="width: 150px; height: auto;"
             class="img-fluid">
          </a>
<!------------------------------------ Buscador ----------------------------------------------------------------------->
          <form class="d-none d-md-flex flex-grow-1" action="buscar.php" method="GET">
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

<!------------------------------------------ Buscador Mobile ------------------------------------------------->
<form class="d-md-none mr-3" action="buscar.php" method="GET">
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

<!----------------------------- Botones Iniciar Sesión, Registrarse y Carrito ------------------------------------->
        <div class="col-lg-8 text-right d-flex justify-content-end align-items-center">
<!--------------------------------------- Buscador móvil ---------------------------------------------------------->
          <form class="d-md-none mr-3" style="width: 150px;">
            <div class="input-group">
              <input 
                type="text" 
                class="form-control" 
                placeholder="Buscar..."
                aria-label="Buscar">
              <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit">
                  <i class='bx bx-search'></i>
                </button>
              </div>
            </div>
          </form>

 
          <?php if(isset($_SESSION['username'])) : ?>
        <!-- Usuario logueado -->
        <div class="d-flex align-items-center mr-3 user-logged">
            <i class='bx bx-user-circle h4 mb-0 mr-2 text-secondary'></i>
            <span class="mr-3"><?= htmlspecialchars($_SESSION['username']) ?></span>
            <a href="logout.php" class="btn btn-outline-dark">Salir</a>
        </div>
        <?php else : ?>
<!---------------------------------------- Usuario no logueado ------------------------------------------------>
          <a href="login.php" class="btn btn-outline-dark mr-2">Iniciar Sesión</a>
          <a href="registro.php" class="btn btn-dark mr-3">Registrarse</a>
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
              <a class="nav-link" href="index.php">Home</a>
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
<!--------------------------------------------- Tipos de Vino --------------------------------------------------->
      <div class="dropdown-col">
      <h6 class="dropdown-category-title">Tipos de Vino</h6>
        <a class="dropdown-item dropdown-wine-item" href="index.php#tintos">Tinto</a>
        <a class="dropdown-item dropdown-wine-item" href="index.php#blancos">Blanco</a>
        <a class="dropdown-item dropdown-wine-item" href="index.php#rosado">Rosado</a>
        <a class="dropdown-item dropdown-wine-item" href="index.php#dulce">Dulce</a>
        <a class="dropdown-item dropdown-wine-item" href="index.php#semi-dulce">Semi-dulce</a>
        <a class="dropdown-item dropdown-wine-item" href="index.php#cava">Cava</a>
        <a class="dropdown-item dropdown-wine-item" href="index.php#vermut">Vermut</a>
        <a class="dropdown-item dropdown-wine-item" href="index.php#hidromiel">Hidromiel</a>
      </div>
<!--------------------------------------- Variedad de uva ---------------------------------------------------->
        <div class="dropdown-col">
        <h6 class="dropdown-category-title">Variedad de uva</h6>
        <a class="dropdown-item dropdown-wine-item" href="vinos.php#variedad-1">Verdejo</a>
        <a class="dropdown-item dropdown-wine-item" href="vinos.php#variedad-2">Sauvignon Blanc</a>
        <a class="dropdown-item dropdown-wine-item" href="vinos.php#variedad-3">Tempranillo</a>
        <a class="dropdown-item dropdown-wine-item" href="vinos.php#variedad-4">Garnacha</a>
        <a class="dropdown-item dropdown-wine-item" href="vinos.php#variedad-5">Moscatel</a>
        <a class="dropdown-item dropdown-wine-item" href="vinos.php#variedad-6">Monastrell</a>
        <a class="dropdown-item dropdown-wine-item" href="vinos.php#variedad-7">Zalema</a>
        <a class="dropdown-item dropdown-wine-item" href="vinos.php#variedad-8">Albariño</a>
        <a class="dropdown-item dropdown-wine-item" href="vinos.php#variedad-9">Palomino Fino</a>
        <a class="dropdown-item dropdown-wine-item" href="vinos.php#variedad-10">Bobal</a>
        <a class="dropdown-item dropdown-wine-item" href="vinos.php#variedad-11">Syrah</a>
        <a class="dropdown-item dropdown-wine-item" href="vinos.php#variedad-12">Parellada y Macabeo</a>
      </div>
 <!------------------------------------ Denominación de Origen -------------------------------------------------->
      <div class="dropdown-col">
      <h6 class="dropdown-category-title">Denominación de Origen</h6>
        <a class="dropdown-item dropdown-wine-item" href="vinos.php#region-1">La Rioja</a>
        <a class="dropdown-item dropdown-wine-item" href="vinos.php#region-2">Ribera del Duero</a>
        <a class="dropdown-item dropdown-wine-item" href="vinos.php#region-3">Jumilla</a>
        <a class="dropdown-item dropdown-wine-item" href="vinos.php#region-4">Calatayud</a>
        <a class="dropdown-item dropdown-wine-item" href="vinos.php#region-5">Pago de Vallegarcía</a>
        <a class="dropdown-item dropdown-wine-item" href="vinos.php#region-6">Yecla</a>
        <a class="dropdown-item dropdown-wine-item" href="vinos.php#region-7">Utiel-Requena</a>
        <a class="dropdown-item dropdown-wine-item" href="vinos.php#region-8">Tierras de Castilla</a>
        <a class="dropdown-item dropdown-wine-item" href="vinos.php#region-9">Condado de Huelva</a>
        <a class="dropdown-item dropdown-wine-item" href="vinos.php#region-10">Rueda</a>
        <a class="dropdown-item dropdown-wine-item" href="vinos.php#region-11">Rías Baixas</a>
        <a class="dropdown-item dropdown-wine-item" href="vinos.php#region-12">Sanlúcar de Barrameda</a>
        <a class="dropdown-item dropdown-wine-item" href="vinos.php#region-13">Sierras de Málaga</a>
        <a class="dropdown-item dropdown-wine-item" href="vinos.php#region-14">La Axarquía</a>
        <a class="dropdown-item dropdown-wine-item" href="vinos.php#region-15">Cigales</a>
        <a class="dropdown-item dropdown-wine-item" href="vinos.php#region-16">Lanjarón</a>
      </div>

<!------------------------------------------------ Envejecimiento ------------------------------------------------>
        <div class="dropdown-col">
        <h6 class="dropdown-category-title">Envejecimiento</h6>
        <a class="dropdown-item dropdown-wine-item" href="vinos.php#crianza-1">Joven</a>
        <a class="dropdown-item dropdown-wine-item" href="vinos.php#crianza-2">Roble</a>
        <a class="dropdown-item dropdown-wine-item" href="vinos.php#crianza-3">Crianza</a>
        <a class="dropdown-item dropdown-wine-item" href="vinos.php#crianza-4">Reserva</a>
      </div>

<!--------------------------------------------------- Precios ---------------------------------------------------->
      <div class="dropdown-col">
      <h6 class="dropdown-category-title">Precios</h6>
      <a class="dropdown-item dropdown-wine-item" href="vinos.php#precio-1">&lt;10 euros</a>
      <a class="dropdown-item dropdown-wine-item" href="vinos.php#precio-2">10-20 €</a>
      <a class="dropdown-item dropdown-wine-item" href="vinos.php#precio-3">20-30 €</a>
      <a class="dropdown-item dropdown-wine-item" href="vinos.php#precio-4">30-40 €</a>
      <a class="dropdown-item dropdown-wine-item" href="vinos.php#precio-5">40-50 €</a>
      <a class="dropdown-item dropdown-wine-item" href="vinos.php#precio-6">50-100 €</a>
      </div>
    </div>
  </div>
</li>


<!--================================================= QUIENES SOMOS ============================================================================= -->


            <li class="nav-item">
              <a class="nav-link" href="index.php#quienes-somos">Quiénes somos</a>
            </li>
<!--================================================= EDITAR PRODUCTOS ============================================================================= -->

        <?php if(isset($_SESSION['user_id']) && $_SESSION['rol'] === 'admin'): ?>
        <li class="nav-item">
            <a class="nav-link" href="editarproductos.php">Editar Productos</a>
        </li>
        <?php endif; ?>
<!--================================================= CONTACTO ============================================================================= -->
            <li class="nav-item">
              <a class="nav-link" href="index.php#contacto">Contacto</a>
            </li>
          </ul>
        </div>

      </div>
    </nav>
  </header>
<body>
  
    
    <!-- Lista de Vinos -->


<!----------------------------------------------VARIEDAD DE UVA ------------------------------------------------------------->
<!--------------------------------------------VERDEJO ------------------------------------------------------------->

<section id="variedad-1" class="category-section py-5">
    <h2 class="text-center mb-5">Vinos de Verdejo</h2>
    <div class="row justify-content-center">
        <?php 
        $vinos = obtenerVinosPorVariedad(1);
        foreach ($vinos as $vino):
        ?>
        <!-- Misma estructura de card -->
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <div class="card wine-card h-100" 
                 onclick="mostrarDetalleVino(<?= $vino['id'] ?>)"
                 data-toggle="modal" 
                 data-target="#modalVino">
                <h5 class="card-title"><?= $vino['nombre'] ?></h5>
                <img src="<?= $vino['imagen'] ?>" class="card-img-top">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price"><?= $vino['precio'] ?>€</span>
                        <button class="btn btn-wine">+ Carrito</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
             <!--------------------------------------------SUAVIGNON BLANC ------------------------------------------------------------->

<section id="variedad-2" class="category-section py-5">
    <h2 class="text-center mb-5">Vinos de Suavignon Blanc</h2>
    <div class="row justify-content-center">
        <?php 
        $vinos = obtenerVinosPorVariedad(2);
        foreach ($vinos as $vino):
        ?>
        <!-- Misma estructura de card -->
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <div class="card wine-card h-100" 
                 onclick="mostrarDetalleVino(<?= $vino['id'] ?>)"
                 data-toggle="modal" 
                 data-target="#modalVino">
                <h5 class="card-title"><?= $vino['nombre'] ?></h5>
                <img src="<?= $vino['imagen'] ?>" class="card-img-top">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price"><?= $vino['precio'] ?>€</span>
                        <button class="btn btn-wine">+ Carrito</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!--------------------------------------------TEMPRANILLO ------------------------------------------------------------->
<section id="variedad-3" class="category-section py-5">
    <h2 class="text-center mb-5">Vinos de Tempranillo</h2>
    <div class="row justify-content-center">
        <?php 
        $vinos = obtenerVinosPorVariedad(3);
        foreach ($vinos as $vino):
        ?>
        <!-- Misma estructura de card -->
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <div class="card wine-card h-100" 
                 onclick="mostrarDetalleVino(<?= $vino['id'] ?>)"
                 data-toggle="modal" 
                 data-target="#modalVino">
                <h5 class="card-title"><?= $vino['nombre'] ?></h5>
                <img src="<?= $vino['imagen'] ?>" class="card-img-top">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price"><?= $vino['precio'] ?>€</span>
                        <button class="btn btn-wine">+ Carrito</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<!--------------------------------------------GARNACHA ------------------------------------------------------------->
<section id="variedad-4" class="category-section py-5">
    <h2 class="text-center mb-5">Vinos de Garnacha</h2>
    <div class="row justify-content-center">
        <?php 
        $vinos = obtenerVinosPorVariedad(4);
        foreach ($vinos as $vino):
        ?>
        <!-- Misma estructura de card -->
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <div class="card wine-card h-100" 
                 onclick="mostrarDetalleVino(<?= $vino['id'] ?>)"
                 data-toggle="modal" 
                 data-target="#modalVino">
                <h5 class="card-title"><?= $vino['nombre'] ?></h5>
                <img src="<?= $vino['imagen'] ?>" class="card-img-top">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price"><?= $vino['precio'] ?>€</span>
                        <button class="btn btn-wine">+ Carrito</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<!--------------------------------------------MOSCATEL ------------------------------------------------------------->
<section id="variedad-5" class="category-section py-5">
    <h2 class="text-center mb-5">Vinos de Moscatel</h2>
    <div class="row justify-content-center">
        <?php 
        $vinos = obtenerVinosPorVariedad(5);
        foreach ($vinos as $vino):
        ?>
        <!-- Misma estructura de card -->
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <div class="card wine-card h-100" 
                 onclick="mostrarDetalleVino(<?= $vino['id'] ?>)"
                 data-toggle="modal" 
                 data-target="#modalVino">
                <h5 class="card-title"><?= $vino['nombre'] ?></h5>
                <img src="<?= $vino['imagen'] ?>" class="card-img-top">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price"><?= $vino['precio'] ?>€</span>
                        <button class="btn btn-wine">+ Carrito</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<!--------------------------------------------MONASTREL ------------------------------------------------------------->
<section id="variedad-6" class="category-section py-5">
    <h2 class="text-center mb-5">Vinos de Monastrel</h2>
    <div class="row justify-content-center">
        <?php 
        $vinos = obtenerVinosPorVariedad(6);
        foreach ($vinos as $vino):
        ?>
        <!-- Misma estructura de card -->
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <div class="card wine-card h-100" 
                 onclick="mostrarDetalleVino(<?= $vino['id'] ?>)"
                 data-toggle="modal" 
                 data-target="#modalVino">
                <h5 class="card-title"><?= $vino['nombre'] ?></h5>
                <img src="<?= $vino['imagen'] ?>" class="card-img-top">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price"><?= $vino['precio'] ?>€</span>
                        <button class="btn btn-wine">+ Carrito</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<!--------------------------------------------ZALEMA ------------------------------------------------------------->
<section id="variedad-7" class="category-section py-5">
    <h2 class="text-center mb-5">Vinos de Zalema</h2>
    <div class="row justify-content-center">
        <?php 
        $vinos = obtenerVinosPorVariedad(7);
        foreach ($vinos as $vino):
        ?>
        <!-- Misma estructura de card -->
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <div class="card wine-card h-100" 
                 onclick="mostrarDetalleVino(<?= $vino['id'] ?>)"
                 data-toggle="modal" 
                 data-target="#modalVino">
                <h5 class="card-title"><?= $vino['nombre'] ?></h5>
                <img src="<?= $vino['imagen'] ?>" class="card-img-top">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price"><?= $vino['precio'] ?>€</span>
                        <button class="btn btn-wine">+ Carrito</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<!--------------------------------------------ALBARIÑO ------------------------------------------------------------->
<section id="variedad-8" class="category-section py-5">
    <h2 class="text-center mb-5">Vinos de Albariño</h2>
    <div class="row justify-content-center">
        <?php 
        $vinos = obtenerVinosPorVariedad(8);
        foreach ($vinos as $vino):
        ?>
        <!-- Misma estructura de card -->
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <div class="card wine-card h-100" 
                 onclick="mostrarDetalleVino(<?= $vino['id'] ?>)"
                 data-toggle="modal" 
                 data-target="#modalVino">
                <h5 class="card-title"><?= $vino['nombre'] ?></h5>
                <img src="<?= $vino['imagen'] ?>" class="card-img-top">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price"><?= $vino['precio'] ?>€</span>
                        <button class="btn btn-wine">+ Carrito</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<!--------------------------------------------PALOMINO FINO ------------------------------------------------------------->
<section id="variedad-9" class="category-section py-5">
    <h2 class="text-center mb-5">Vinos de Palomino Fino</h2>
    <div class="row justify-content-center">
        <?php 
        $vinos = obtenerVinosPorVariedad(9);
        foreach ($vinos as $vino):
        ?>
        <!-- Misma estructura de card -->
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <div class="card wine-card h-100" 
                 onclick="mostrarDetalleVino(<?= $vino['id'] ?>)"
                 data-toggle="modal" 
                 data-target="#modalVino">
                <h5 class="card-title"><?= $vino['nombre'] ?></h5>
                <img src="<?= $vino['imagen'] ?>" class="card-img-top">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price"><?= $vino['precio'] ?>€</span>
                        <button class="btn btn-wine">+ Carrito</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<!--------------------------------------------BOBAL ------------------------------------------------------------->
<section id="variedad-10" class="category-section py-5">
    <h2 class="text-center mb-5">Vinos de Bobal</h2>
    <div class="row justify-content-center">
        <?php 
        $vinos = obtenerVinosPorVariedad(10);
        foreach ($vinos as $vino):
        ?>
        <!-- Misma estructura de card -->
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <div class="card wine-card h-100" 
                 onclick="mostrarDetalleVino(<?= $vino['id'] ?>)"
                 data-toggle="modal" 
                 data-target="#modalVino">
                <h5 class="card-title"><?= $vino['nombre'] ?></h5>
                <img src="<?= $vino['imagen'] ?>" class="card-img-top">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price"><?= $vino['precio'] ?>€</span>
                        <button class="btn btn-wine">+ Carrito</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<!--------------------------------------------SYRAH ------------------------------------------------------------->
<section id="variedad-11" class="category-section py-5">
    <h2 class="text-center mb-5">Vinos de Syrah</h2>
    <div class="row justify-content-center">
        <?php 
        $vinos = obtenerVinosPorVariedad(11);
        foreach ($vinos as $vino):
        ?>
        <!-- Misma estructura de card -->
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <div class="card wine-card h-100" 
                 onclick="mostrarDetalleVino(<?= $vino['id'] ?>)"
                 data-toggle="modal" 
                 data-target="#modalVino">
                <h5 class="card-title"><?= $vino['nombre'] ?></h5>
                <img src="<?= $vino['imagen'] ?>" class="card-img-top">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price"><?= $vino['precio'] ?>€</span>
                        <button class="btn btn-wine">+ Carrito</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<!--------------------------------------------PARELLADA Y MACABEO ------------------------------------------------------------->
<section id="variedad-12" class="category-section py-5">
    <h2 class="text-center mb-5">Vinos de Parellada y Macabeo</h2>
    <div class="row justify-content-center">
        <?php 
        $vinos = obtenerVinosPorVariedad(12);
        foreach ($vinos as $vino):
        ?>
        <!-- Misma estructura de card -->
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <div class="card wine-card h-100" 
                 onclick="mostrarDetalleVino(<?= $vino['id'] ?>)"
                 data-toggle="modal" 
                 data-target="#modalVino">
                <h5 class="card-title"><?= $vino['nombre'] ?></h5>
                <img src="<?= $vino['imagen'] ?>" class="card-img-top">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price"><?= $vino['precio'] ?>€</span>
                        <button class="btn btn-wine">+ Carrito</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!----------------------------------------------DENOMINACIÓN DE ORIGEN ------------------------------------------------------------->
<!----------------------------------------------1LA RIOJA ------------------------------------------------------------->

<section id="region-1" class="category-section py-5">
    <h2 class="text-center mb-5">La Rioja</h2>
    <div class="row justify-content-center">
        <?php 
        $vinos = obtenerVinosPorRegion(1);
        foreach ($vinos as $vino):
        ?>
        <!-- Misma estructura de card -->
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <div class="card wine-card h-100" 
                 onclick="mostrarDetalleVino(<?= $vino['id'] ?>)"
                 data-toggle="modal" 
                 data-target="#modalVino">
                <h5 class="card-title"><?= $vino['nombre'] ?></h5>
                <img src="<?= $vino['imagen'] ?>" class="card-img-top">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price"><?= $vino['precio'] ?>€</span>
                        <button class="btn btn-wine">+ Carrito</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!----------------------------------------------2RIBERA DEL DUERO ------------------------------------------------------------->

<section id="region-2" class="category-section py-5">
    <h2 class="text-center mb-5">Ribera del Duero</h2>
    <div class="row justify-content-center">
        <?php 
        $vinos = obtenerVinosPorRegion(2);
        foreach ($vinos as $vino):
        ?>
        <!-- Misma estructura de card -->
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <div class="card wine-card h-100" 
                 onclick="mostrarDetalleVino(<?= $vino['id'] ?>)"
                 data-toggle="modal" 
                 data-target="#modalVino">
                <h5 class="card-title"><?= $vino['nombre'] ?></h5>
                <img src="<?= $vino['imagen'] ?>" class="card-img-top">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price"><?= $vino['precio'] ?>€</span>
                        <button class="btn btn-wine">+ Carrito</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<!----------------------------------------------3JUMILLA ------------------------------------------------------------->
<section id="region-3" class="category-section py-5">
    <h2 class="text-center mb-5">Jumilla</h2>
    <div class="row justify-content-center">
        <?php 
        $vinos = obtenerVinosPorRegion(3);
        foreach ($vinos as $vino):
        ?>
        <!-- Misma estructura de card -->
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <div class="card wine-card h-100" 
                 onclick="mostrarDetalleVino(<?= $vino['id'] ?>)"
                 data-toggle="modal" 
                 data-target="#modalVino">
                <h5 class="card-title"><?= $vino['nombre'] ?></h5>
                <img src="<?= $vino['imagen'] ?>" class="card-img-top">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price"><?= $vino['precio'] ?>€</span>
                        <button class="btn btn-wine">+ Carrito</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!----------------------------------------------4CALATAYUD ------------------------------------------------------------->

<section id="region-4" class="category-section py-5">
    <h2 class="text-center mb-5">Calatayud</h2>
    <div class="row justify-content-center">
        <?php 
        $vinos = obtenerVinosPorRegion(4);
        foreach ($vinos as $vino):
        ?>
        <!-- Misma estructura de card -->
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <div class="card wine-card h-100" 
                 onclick="mostrarDetalleVino(<?= $vino['id'] ?>)"
                 data-toggle="modal" 
                 data-target="#modalVino">
                <h5 class="card-title"><?= $vino['nombre'] ?></h5>
                <img src="<?= $vino['imagen'] ?>" class="card-img-top">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price"><?= $vino['precio'] ?>€</span>
                        <button class="btn btn-wine">+ Carrito</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!----------------------------------------------5PAGO DE VALLEGARCIA ------------------------------------------------------------->

<section id="region-5" class="category-section py-5">
    <h2 class="text-center mb-5">Pago de Vallegarcia</h2>
    <div class="row justify-content-center">
        <?php 
        $vinos = obtenerVinosPorRegion(5);
        foreach ($vinos as $vino):
        ?>
        <!-- Misma estructura de card -->
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <div class="card wine-card h-100" 
                 onclick="mostrarDetalleVino(<?= $vino['id'] ?>)"
                 data-toggle="modal" 
                 data-target="#modalVino">
                <h5 class="card-title"><?= $vino['nombre'] ?></h5>
                <img src="<?= $vino['imagen'] ?>" class="card-img-top">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price"><?= $vino['precio'] ?>€</span>
                        <button class="btn btn-wine">+ Carrito</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!----------------------------------------------6YECLA ------------------------------------------------------------->

<section id="region-6" class="category-section py-5">
    <h2 class="text-center mb-5">Yecla</h2>
    <div class="row justify-content-center">
        <?php 
        $vinos = obtenerVinosPorRegion(6);
        foreach ($vinos as $vino):
        ?>
        <!-- Misma estructura de card -->
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <div class="card wine-card h-100" 
                 onclick="mostrarDetalleVino(<?= $vino['id'] ?>)"
                 data-toggle="modal" 
                 data-target="#modalVino">
                <h5 class="card-title"><?= $vino['nombre'] ?></h5>
                <img src="<?= $vino['imagen'] ?>" class="card-img-top">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price"><?= $vino['precio'] ?>€</span>
                        <button class="btn btn-wine">+ Carrito</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!----------------------------------------------7UTIEL-REQUENA ------------------------------------------------------------->

<section id="region-7" class="category-section py-5">
    <h2 class="text-center mb-5">Utiel-Requena</h2>
    <div class="row justify-content-center">
        <?php 
        $vinos = obtenerVinosPorRegion(7);
        foreach ($vinos as $vino):
        ?>
        <!-- Misma estructura de card -->
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <div class="card wine-card h-100" 
                 onclick="mostrarDetalleVino(<?= $vino['id'] ?>)"
                 data-toggle="modal" 
                 data-target="#modalVino">
                <h5 class="card-title"><?= $vino['nombre'] ?></h5>
                <img src="<?= $vino['imagen'] ?>" class="card-img-top">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price"><?= $vino['precio'] ?>€</span>
                        <button class="btn btn-wine">+ Carrito</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!----------------------------------------------8TIERRAS DE CASTILLA ------------------------------------------------------------->


<section id="region-8" class="category-section py-5">
    <h2 class="text-center mb-5">Tierras de Castilla</h2>
    <div class="row justify-content-center">
        <?php 
        $vinos = obtenerVinosPorRegion(8);
        foreach ($vinos as $vino):
        ?>
        <!-- Misma estructura de card -->
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <div class="card wine-card h-100" 
                 onclick="mostrarDetalleVino(<?= $vino['id'] ?>)"
                 data-toggle="modal" 
                 data-target="#modalVino">
                <h5 class="card-title"><?= $vino['nombre'] ?></h5>
                <img src="<?= $vino['imagen'] ?>" class="card-img-top">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price"><?= $vino['precio'] ?>€</span>
                        <button class="btn btn-wine">+ Carrito</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<!----------------------------------------------9CONDADO DE HUELVA ------------------------------------------------------------->

<section id="region-9" class="category-section py-5">
    <h2 class="text-center mb-5">Condado de Huelva</h2>
    <div class="row justify-content-center">
        <?php 
        $vinos = obtenerVinosPorRegion(9);
        foreach ($vinos as $vino):
        ?>
        <!-- Misma estructura de card -->
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <div class="card wine-card h-100" 
                 onclick="mostrarDetalleVino(<?= $vino['id'] ?>)"
                 data-toggle="modal" 
                 data-target="#modalVino">
                <h5 class="card-title"><?= $vino['nombre'] ?></h5>
                <img src="<?= $vino['imagen'] ?>" class="card-img-top">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price"><?= $vino['precio'] ?>€</span>
                        <button class="btn btn-wine">+ Carrito</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!----------------------------------------------10RUEDA ------------------------------------------------------------->

<section id="region-10" class="category-section py-5">
    <h2 class="text-center mb-5">Rueda</h2>
    <div class="row justify-content-center">
        <?php 
        $vinos = obtenerVinosPorRegion(10);
        foreach ($vinos as $vino):
        ?>
        <!-- Misma estructura de card -->
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <div class="card wine-card h-100" 
                 onclick="mostrarDetalleVino(<?= $vino['id'] ?>)"
                 data-toggle="modal" 
                 data-target="#modalVino">
                <h5 class="card-title"><?= $vino['nombre'] ?></h5>
                <img src="<?= $vino['imagen'] ?>" class="card-img-top">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price"><?= $vino['precio'] ?>€</span>
                        <button class="btn btn-wine">+ Carrito</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>


<!----------------------------------------------11 RIAS BAIXAS ------------------------------------------------------------->


<section id="region-11" class="category-section py-5">
    <h2 class="text-center mb-5">Rias Baixas</h2>
    <div class="row justify-content-center">
        <?php 
        $vinos = obtenerVinosPorRegion(11);
        foreach ($vinos as $vino):
        ?>
        <!-- Misma estructura de card -->
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <div class="card wine-card h-100" 
                 onclick="mostrarDetalleVino(<?= $vino['id'] ?>)"
                 data-toggle="modal" 
                 data-target="#modalVino">
                <h5 class="card-title"><?= $vino['nombre'] ?></h5>
                <img src="<?= $vino['imagen'] ?>" class="card-img-top">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price"><?= $vino['precio'] ?>€</span>
                        <button class="btn btn-wine">+ Carrito</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!----------------------------------------------12 SANLUCAS DE BARRAMEDA ------------------------------------------------------------->


<section id="region-12" class="category-section py-5">
    <h2 class="text-center mb-5">Sanlúcar de Barrameda</h2>
    <div class="row justify-content-center">
        <?php 
        $vinos = obtenerVinosPorRegion(12);
        foreach ($vinos as $vino):
        ?>
        <!-- Misma estructura de card -->
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <div class="card wine-card h-100" 
                 onclick="mostrarDetalleVino(<?= $vino['id'] ?>)"
                 data-toggle="modal" 
                 data-target="#modalVino">
                <h5 class="card-title"><?= $vino['nombre'] ?></h5>
                <img src="<?= $vino['imagen'] ?>" class="card-img-top">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price"><?= $vino['precio'] ?>€</span>
                        <button class="btn btn-wine">+ Carrito</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!----------------------------------------------13SIERRAS DE MALAGA ------------------------------------------------------------->


<section id="region-13" class="category-section py-5">
    <h2 class="text-center mb-5">Sierras de Málaga</h2>
    <div class="row justify-content-center">
        <?php 
        $vinos = obtenerVinosPorRegion(13);
        foreach ($vinos as $vino):
        ?>
        <!-- Misma estructura de card -->
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <div class="card wine-card h-100" 
                 onclick="mostrarDetalleVino(<?= $vino['id'] ?>)"
                 data-toggle="modal" 
                 data-target="#modalVino">
                <h5 class="card-title"><?= $vino['nombre'] ?></h5>
                <img src="<?= $vino['imagen'] ?>" class="card-img-top">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price"><?= $vino['precio'] ?>€</span>
                        <button class="btn btn-wine">+ Carrito</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!----------------------------------------------14LA AXARQUIA ------------------------------------------------------------->


<section id="region-14" class="category-section py-5">
    <h2 class="text-center mb-5">Vermut de La Axarquia, Málaga</h2>
    <div class="row justify-content-center">
        <?php 
        $vinos = obtenerVinosPorRegion(14);
        foreach ($vinos as $vino):
        ?>
        <!-- Misma estructura de card -->
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <div class="card wine-card h-100" 
                 onclick="mostrarDetalleVino(<?= $vino['id'] ?>)"
                 data-toggle="modal" 
                 data-target="#modalVino">
                <h5 class="card-title"><?= $vino['nombre'] ?></h5>
                <img src="<?= $vino['imagen'] ?>" class="card-img-top">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price"><?= $vino['precio'] ?>€</span>
                        <button class="btn btn-wine">+ Carrito</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>


<!----------------------------------------------15CIGALES ------------------------------------------------------------->
<section id="region-15" class="category-section py-5">
    <h2 class="text-center mb-5">Cigales</h2>
    <div class="row justify-content-center">
        <?php 
        $vinos = obtenerVinosPorRegion(15);
        foreach ($vinos as $vino):
        ?>
        <!-- Misma estructura de card -->
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <div class="card wine-card h-100" 
                 onclick="mostrarDetalleVino(<?= $vino['id'] ?>)"
                 data-toggle="modal" 
                 data-target="#modalVino">
                <h5 class="card-title"><?= $vino['nombre'] ?></h5>
                <img src="<?= $vino['imagen'] ?>" class="card-img-top">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price"><?= $vino['precio'] ?>€</span>
                        <button class="btn btn-wine">+ Carrito</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!----------------------------------------------16 LANJARÓN ------------------------------------------------------------->
<section id="region-16" class="category-section py-5">
    <h2 class="text-center mb-5">Hidromiel de Lanjarón</h2>
    <div class="row justify-content-center">
        <?php 
        $vinos = obtenerVinosPorRegion(16);
        foreach ($vinos as $vino):
        ?>
        <!-- Misma estructura de card -->
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <div class="card wine-card h-100" 
                 onclick="mostrarDetalleVino(<?= $vino['id'] ?>)"
                 data-toggle="modal" 
                 data-target="#modalVino">
                <h5 class="card-title"><?= $vino['nombre'] ?></h5>
                <img src="<?= $vino['imagen'] ?>" class="card-img-top">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price"><?= $vino['precio'] ?>€</span>
                        <button class="btn btn-wine">+ Carrito</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!----------------------------------------------CRIANZA ------------------------------------------------------------->
<!----------------------------------------------1JOVEN ------------------------------------------------------------->

<section id="crianza-1" class="category-section py-5">
    <h2 class="text-center mb-5">Vinos Jóvenes y blancos</h2>
    <div class="row justify-content-center">
        <?php 
        $vinos = obtenerVinosPorCrianza(1);
        foreach ($vinos as $vino):
        ?>
        <!-- Misma estructura de card -->
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <div class="card wine-card h-100" 
                 onclick="mostrarDetalleVino(<?= $vino['id'] ?>)"
                 data-toggle="modal" 
                 data-target="#modalVino">
                <h5 class="card-title"><?= $vino['nombre'] ?></h5>
                <img src="<?= $vino['imagen'] ?>" class="card-img-top">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price"><?= $vino['precio'] ?>€</span>
                        <button class="btn btn-wine">+ Carrito</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<!----------------------------------------------2ROBLE ------------------------------------------------------------->
<section id="crianza-2" class="category-section py-5">
    <h2 class="text-center mb-5">Vinos Roble</h2>
    <div class="row justify-content-center">
        <?php 
        $vinos = obtenerVinosPorCrianza(2);
        foreach ($vinos as $vino):
        ?>
        <!-- Misma estructura de card -->
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <div class="card wine-card h-100" 
                 onclick="mostrarDetalleVino(<?= $vino['id'] ?>)"
                 data-toggle="modal" 
                 data-target="#modalVino">
                <h5 class="card-title"><?= $vino['nombre'] ?></h5>
                <img src="<?= $vino['imagen'] ?>" class="card-img-top">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price"><?= $vino['precio'] ?>€</span>
                        <button class="btn btn-wine">+ Carrito</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!----------------------------------------------3CRIANZA ------------------------------------------------------------->
<section id="crianza-3" class="category-section py-5">
    <h2 class="text-center mb-5">Vinos Crianza</h2>
    <div class="row justify-content-center">
        <?php 
        $vinos = obtenerVinosPorCrianza(3);
        foreach ($vinos as $vino):
        ?>
        <!-- Misma estructura de card -->
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <div class="card wine-card h-100" 
                 onclick="mostrarDetalleVino(<?= $vino['id'] ?>)"
                 data-toggle="modal" 
                 data-target="#modalVino">
                <h5 class="card-title"><?= $vino['nombre'] ?></h5>
                <img src="<?= $vino['imagen'] ?>" class="card-img-top">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price"><?= $vino['precio'] ?>€</span>
                        <button class="btn btn-wine">+ Carrito</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<!----------------------------------------------3RESERVA ------------------------------------------------------------->

<section id="crianza-4" class="category-section py-5">
    <h2 class="text-center mb-5">Vino Reserva</h2>
    <div class="row justify-content-center">
        <?php 
        $vinos = obtenerVinosPorCrianza(4);
        foreach ($vinos as $vino):
        ?>
        <!-- Misma estructura de card -->
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <div class="card wine-card h-100" 
                 onclick="mostrarDetalleVino(<?= $vino['id'] ?>)"
                 data-toggle="modal" 
                 data-target="#modalVino">
                <h5 class="card-title"><?= $vino['nombre'] ?></h5>
                <img src="<?= $vino['imagen'] ?>" class="card-img-top">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price"><?= $vino['precio'] ?>€</span>
                        <button class="btn btn-wine">+ Carrito</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!----------------------------------------------Precios ------------------------------------------------------------->
<!----------------------------------------------1<10 € ------------------------------------------------------------->
<section id="precio-1" class="category-section py-5">
    <h2 class="text-center mb-5">< 10 €</h2>
    <div class="row justify-content-center">
        <?php 
        $vinos = obtenerVinosPorPrecio(1);
        foreach ($vinos as $vino):
        ?>
        <!-- Misma estructura de card -->
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <div class="card wine-card h-100" 
                 onclick="mostrarDetalleVino(<?= $vino['id'] ?>)"
                 data-toggle="modal" 
                 data-target="#modalVino">
                <h5 class="card-title"><?= $vino['nombre'] ?></h5>
                <img src="<?= $vino['imagen'] ?>" class="card-img-top">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price"><?= $vino['precio'] ?>€</span>
                        <button class="btn btn-wine">+ Carrito</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<!----------------------------------------------2 10-20 €------------------------------------------------------------->
<section id="precio-2" class="category-section py-5">
    <h2 class="text-center mb-5">10-20 €</h2>
    <div class="row justify-content-center">
        <?php 
        $vinos = obtenerVinosPorPrecio(2);
        foreach ($vinos as $vino):
        ?>
        <!-- Misma estructura de card -->
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <div class="card wine-card h-100" 
                 onclick="mostrarDetalleVino(<?= $vino['id'] ?>)"
                 data-toggle="modal" 
                 data-target="#modalVino">
                <h5 class="card-title"><?= $vino['nombre'] ?></h5>
                <img src="<?= $vino['imagen'] ?>" class="card-img-top">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price"><?= $vino['precio'] ?>€</span>
                        <button class="btn btn-wine">+ Carrito</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<!----------------------------------------------3 20-30 € ------------------------------------------------------------->
<section id="precio-3" class="category-section py-5">
    <h2 class="text-center mb-5">20-30 €</h2>
    <div class="row justify-content-center">
        <?php 
        $vinos = obtenerVinosPorPrecio(3);
        foreach ($vinos as $vino):
        ?>
        <!-- Misma estructura de card -->
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <div class="card wine-card h-100" 
                 onclick="mostrarDetalleVino(<?= $vino['id'] ?>)"
                 data-toggle="modal" 
                 data-target="#modalVino">
                <h5 class="card-title"><?= $vino['nombre'] ?></h5>
                <img src="<?= $vino['imagen'] ?>" class="card-img-top">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price"><?= $vino['precio'] ?>€</span>
                        <button class="btn btn-wine">+ Carrito</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<!----------------------------------------------4 30-40 € ------------------------------------------------------------->
<section id="precio-4" class="category-section py-5">
    <h2 class="text-center mb-5">30-40 €</h2>
    <div class="row justify-content-center">
        <?php 
        $vinos = obtenerVinosPorPrecio(4);
        foreach ($vinos as $vino):
        ?>
        <!-- Misma estructura de card -->
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <div class="card wine-card h-100" 
                 onclick="mostrarDetalleVino(<?= $vino['id'] ?>)"
                 data-toggle="modal" 
                 data-target="#modalVino">
                <h5 class="card-title"><?= $vino['nombre'] ?></h5>
                <img src="<?= $vino['imagen'] ?>" class="card-img-top">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price"><?= $vino['precio'] ?>€</span>
                        <button class="btn btn-wine">+ Carrito</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<!----------------------------------------------5 50-100 €------------------------------------------------------------->
<section id="precio-5" class="category-section py-5">
    <h2 class="text-center mb-5">50-100 €</h2>
    <div class="row justify-content-center">
        <?php 
        $vinos = obtenerVinosPorPrecio(5);
        foreach ($vinos as $vino):
        ?>
        <!-- Misma estructura de card -->
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <div class="card wine-card h-100" 
                 onclick="mostrarDetalleVino(<?= $vino['id'] ?>)"
                 data-toggle="modal" 
                 data-target="#modalVino">
                <h5 class="card-title"><?= $vino['nombre'] ?></h5>
                <img src="<?= $vino['imagen'] ?>" class="card-img-top">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price"><?= $vino['precio'] ?>€</span>
                        <button class="btn btn-wine">+ Carrito</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<!----------------------------------------------6 >100 € ------------------------------------------------------------->
<section id="precio-6" class="category-section py-5">
    <h2 class="text-center mb-5">> 100 €</h2>
    <div class="row justify-content-center">
        <?php 
        $vinos = obtenerVinosPorPrecio(6);
        foreach ($vinos as $vino):
        ?>
        <!-- Misma estructura de card -->
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <div class="card wine-card h-100" 
                 onclick="mostrarDetalleVino(<?= $vino['id'] ?>)"
                 data-toggle="modal" 
                 data-target="#modalVino">
                <h5 class="card-title"><?= $vino['nombre'] ?></h5>
                <img src="<?= $vino['imagen'] ?>" class="card-img-top">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="price"><?= $vino['precio'] ?>€</span>
                        <button class="btn btn-wine">+ Carrito</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!---------------------------------------------- Paginación ---------------------------------------------------->
<?php if ($total_paginas > 1): ?>
<nav>
    <ul class="pagination">
        <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
            <li class="page-item <?= ($i == $pagina_actual) ? 'active' : '' ?>">
                <a class="page-link" 
                   href="vinos.php?<?= $filtro ? "filtro=$filtro&id=$id&" : '' ?>page=<?= $i ?>">
                    <?= $i ?>
                </a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>
<?php endif; ?>

<!------------------------------------------ FOOTER ----------------------------------------------------------->
    <footer class="footer bg-dark text-white pt-4">
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <h5>Nuestra información</h5>
          <ul class="list-unstyled">
            <li>Málaga, España</li>
            <li>Calle: Hernán Nuñez de Toledo, 16</li>
            <li>+34 698 765 432</li>
          </ul>
        </div>
        <div class="col-md-3">
          <h5>Sobre nosotros</h5>
          <ul class="list-unstyled">
            <li><a href="#" class="text-white">Atención al cliente</a></li>
            <li><a href="#" class="text-white">Política de privacidad</a></li>
            <li><a href="#" class="text-white">Sobre Nosotros</a></li>
            <li><a href="#" class="text-white">CopyRight</a></li>
          </ul>
        </div>
        <div class="col-md-3">
          <h5>Producto</h5>
          <ul class="list-unstyled">
          <li><a href="index.php#tintos" class="text-white">Tinto</a></li>
            <li><a href="index.php#blancos" class="text-white">Blanco</a></li>
            <li><a href="index.php#rosado" class="text-white">Rosado</a></li>
            <li><a href="index.php#dulce" class="text-white">Dulce</a></li>
            <li><a href="index.php#cava" class="text-white">Cava</a></li>
            <li><a href="index.php#vermut" class="text-white">Vermut</a></li>
          </ul>
        </div>
        <div class="col-md-3">
          <h5>Social</h5>
          <ul class="list-unstyled d-flex">
            <li class="mr-3">
              <a href="https://www.facebook.com/" target="_blank" class="text-white">
                <i class='bx bxl-facebook'></i> Facebook
              </a>
            </li>
            <li>
              <a href="https://www.instagram.com/" target="_blank" class="text-white">
                <i class='bx bxl-instagram-alt'></i> Instagram
              </a>
            </li>
          </ul>
        </div>
      </div>
      <div class="text-center mt-3">
        <span>&#169; All rights reserved</span>
      </div>
    </div>
  </footer>

  <!-- Scripts de Bootstrap y dependencias -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <!-- Tu archivo JS personalizado (opcional) -->
  <script src="js/main.js"></script>

  <!-- Botón flotante de WhatsApp -->
  <a href="https://wa.me/+34653501482?text=Hola%2C%20me%20gustar%C3%ADa%20consultar%20sobre%20lo%20siguiente" 
  class="whatsapp-btn" 
  target="_blank">
 <i class='bx bxl-whatsapp'></i>
</a>

</script>

<!-- Modal -->
<div class="modal fade" id="modalVino">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-wine text-white">
                <h5 class="modal-title" id="modalTitulo"></h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <img id="modalImagen" class="img-fluid">
                    </div>
                    <div class="col-md-6">
                        <p id="modalDescripcion"></p>
                        <ul class="list-unstyled">
                            <li><strong>Región:</strong> <span id="modalRegion"></span></li>
                            <li><strong>Uva:</strong> <span id="modalVariedad"></span></li>
                            <li><strong>Crianza:</strong> <span id="modalCrianza"></span></li>
                        </ul>
                        <h4 class="text-wine" id="modalPrecio"></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
  // Cerrar el dropdown al hacer clic en cualquier item del menú Vinos
  $('.dropdown-menu-vinos a').on('click', function() {
    $('.dropdown-vinos').removeClass('show');
    $('.dropdown-menu-vinos').removeClass('show');
  });

  // Cerrar el dropdown al hacer clic fuera en móviles
  $(document).on('click', function(e) {
    if($(window).width() < 992) {
      if(!$(e.target).closest('.dropdown-vinos').length) {
        $('.dropdown-vinos').removeClass('show');
        $('.dropdown-menu-vinos').removeClass('show');
      }
    }
  });
});
</script>
</body>
</html>
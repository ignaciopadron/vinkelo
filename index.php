<?php 
require 'config.php';
require 'funciones.php'; 
?>

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
  <link rel="stylesheet" href="style.css">
</head>
<body>
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
          <form class="d-none d-md-flex flex-grow-1 mr3" action="buscar.php" method="GET">
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


  <!--==================== HERO SECTION ====================-->
<section class="hero-section">
    <div class="container h-100">
      <div class="row h-100 align-items-center">
      </div>
    </div>
  </section>
  


  <!-------------------------------------- TIPOS de VINOS ---------------------------------------------------------------->
  <!----------------------------------VINOS TINTOS ------------------------------------------------------------->

 <!------------------------------------ Sección Vinos Tintos ---------------------------------------------- -->
<section id="tintos" class="category-section py-5">
    <h2 class="text-center mb-5">Vinos Tintos</h2>
    <div class="row justify-content-center">
        <?php 
        // Obtener vinos tipo 1 (tintos)
        $vinos = obtenerVinosPorTipo(1); 
        foreach ($vinos as $vino):
        ?>
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

  <!----------------------------------VINOS BLANCOS ------------------------------------------------------------->
  <section id="blancos" class="category-section py-5">
    <h2 class="text-center mb-5">Vinos Blancos</h2>
    <div class="row justify-content-center">
        <?php 
        $vinos = obtenerVinosPorTipo(2); // Tipo 2 = blanco
        foreach ($vinos as $vino):
        ?>
        <!-- Misma estructura de card que en tintos -->
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
  <!----------------------------------VINO ROSADO ------------------------------------------------------------->

<section id="rosado" class="category-section py-5">
    <h2 class="text-center mb-5">Vinos Rosados</h2>
    <div class="row justify-content-center">
        <?php 
        $vinos = obtenerVinosPorTipo(3);
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

  <!----------------------------------VINO DULCE ------------------------------------------------------------->
  <section id="dulce" class="category-section py-5">
    <h2 class="text-center mb-5">Vinos Dulce</h2>
    <div class="row justify-content-center">
        <?php 
        $vinos = obtenerVinosPorTipo(4);
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
  <!----------------------------------VINO SEMI-DULCE ------------------------------------------------------------->
  <section id="semi-dulce" class="category-section py-5">
    <h2 class="text-center mb-5">Vinos Semi-Dulce</h2>
    <div class="row justify-content-center">
        <?php 
        $vinos = obtenerVinosPorTipo(5);
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

  <!----------------------------------VINO VERMUT ------------------------------------------------------------->
  <section id="vermut" class="category-section py-5">
    <h2 class="text-center mb-5">Vermut</h2>
    <div class="row justify-content-center">
        <?php 
        $vinos = obtenerVinosPorTipo(8);
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

  <!----------------------------------HIDROMIEL ------------------------------------------------------------->
  <section id="hidromiel" class="category-section py-5">
    <h2 class="text-center mb-5">Hidromiel</h2>
    <div class="row justify-content-center">
        <?php 
        $vinos = obtenerVinosPorTipo(9);
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
 






<!--==================== QUIÉNES SOMOS ====================-->
<section id="quienes-somos" class="story section container py-5">
    <div class="story__container grid">
        <div class="story__data">
            <h2 class="section__title story__section-title">
                Nuestra Historia
            </h2>

            <h1 class="story__title mb-4">
                Vinkelo - Pasión por el vino español
            </h1>

            <p class="story__description lead">
                Desde 2010, nos dedicamos a seleccionar los mejores vinos de las principales Denominaciones de Origen de España, trabajando directamente con más de 50 bodegas artesanales y cooperativas locales. 
            </p>
            
            <p class="story__description">
                Nuestra misión es llevar a tu mesa la auténtica esencia del viñedo español, combinando tradición centenaria y técnicas modernas de elaboración. Colaboramos con bodegas familiares de La Rioja, Ribera del Duero, Jumilla y otras regiones vinícolas, garantizando siempre la mejor relación calidad-precio.
            </p>

            <p class="story__description">
                En Vinkelo encontrarás una cuidada selección de:
            </p>
            
            <ul class="story__description">
                <li>Vinos de pequeñas producciones</li>
                <li>Etiquetas ecológicas certificadas</li>
                <li>Selecciones especiales de enólogos</li>
                <li>Referencias premiadas internacionalmente</li>
            </ul>

            <a href="index.php#tintos" class="btn btn-wine">Descubre nuestra selección</a>
        </div>

        <div class="story__images">
            <img src="img/portada_vinkelo.jpg" 
                 alt="Bodega tradicional española" 
                 class="img-fluid rounded shadow-lg"
                 style="max-height: 500px">
        </div>
    </div>
</section>

  <!--==================== CONTACTO ====================-->
<section id="contacto" class="contact-section py-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <h2 class="text-center mb-5">Contacto</h2>
        <form>
          <div class="form-row">
            <div class="form-group col-md-6">
              <input type="text" class="form-control" placeholder="Nombre">
            </div>
            <div class="form-group col-md-6">
              <input type="email" class="form-control" placeholder="Email">
            </div>
          </div>
          <div class="form-group">
            <textarea class="form-control" rows="4" placeholder="Mensaje"></textarea>
          </div>
          <button type="submit" class="btn btn-wine btn-block">Enviar Mensaje</button>
        </form>
      </div>
    </div>
  </section>
 

  <!--==================== FOOTER ====================-->
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
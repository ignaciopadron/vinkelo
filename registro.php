
<?php
require 'config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validaciones
    if (empty($username) || empty($password)) {
        $error = 'Todos los campos son obligatorios';
    } elseif ($password !== $confirm_password) {
        $error = 'Las contraseñas no coinciden';
    } else {
        try {
            // Verificar si el usuario existe
            $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = ?");
            $stmt->execute([$username]);
            
            if ($stmt->rowCount() > 0) {
                $error = 'El nombre de usuario ya está registrado';
            } else {
                // Hash de contraseña segura
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                
                // Insertar nuevo usuario
                $stmt = $pdo->prepare("INSERT INTO usuarios (username, password, rol) VALUES (?, ?, 'cliente')");
                $stmt->execute([$username, $password_hash]);
                
                $success = 'Registro exitoso! Ahora puedes iniciar sesión';
            }
        } catch (PDOException $e) {
            $error = 'Error en el registro: ' . $e->getMessage();
        }
    }
}
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
    

<!---------------------------------------------------- REGISTRO DE USUARIO  ----------------------------------------------------------------------------------------------->
    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="mb-4">Registro de Usuario</h2>
                
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                    <div class="alert alert-success"><?= $success ?></div>
                <?php else: ?>
                    <form method="POST">
                        <div class="form-group">
                            <label>Nombre de usuario:</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Contraseña:</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Confirmar contraseña:</label>
                            <input type="password" name="confirm_password" class="form-control" required>
                        </div>
                        
                        <button type="submit" class="btn btn-wine btn-block">Registrarse</button>
                    </form>
                <?php endif; ?>
                
                <div class="mt-3 text-center">
                    ¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a>
                </div>
            </div>
        </div>
    </main>
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
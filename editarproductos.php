<?php

require 'config.php';
require 'funciones.php';

// Verificar permisos
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Obtener todos los productos
$vinos = [];
try {
    $stmt = $pdo->query("SELECT v.*, 
                        t.nombre as tipo_nombre,
                        r.nombre as region_nombre,
                        vu.nombre as variedad_nombre,
                        c.nombre as crianza_nombre,
                        pr.etiqueta as precio_etiqueta
                    FROM vinos v
                    LEFT JOIN tipos_vinos t ON v.tipo_id = t.id
                    LEFT JOIN regiones r ON v.region_id = r.id
                    LEFT JOIN variedades_uva vu ON v.variedad_id = vu.id
                    LEFT JOIN crianzas c ON v.crianza_id = c.id
                    LEFT JOIN precios_rango pr ON v.precio_id = pr.id");
    $vinos = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = "Error al obtener productos: " . $e->getMessage();
}

// Manejar operaciones CRUD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = sanitizarInput($_POST['nombre']);
    $tipo_id = (int)$_POST['tipo_id'];
    $region_id = (int)$_POST['region_id'];
    $variedad_id = (int)$_POST['variedad_id'];
    $crianza_id = (int)$_POST['crianza_id'];
    $descripcion = sanitizarInput($_POST['descripcion']);
    $precio = (float)$_POST['precio'];
    $precio_id = (int)$_POST['precio_id'];
    
    // Subida de imagen
    $imagen = $_POST['imagen_actual'] ?? '';
    if (!empty($_FILES['imagen']['name'])) {
        $uploadDir = 'img/';
        $fileName = basename($_FILES['imagen']['name']);
        $targetPath = $uploadDir . $fileName;
        
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $targetPath)) {
            $imagen = $targetPath;
        }
    }

    try {
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            // Actualizar
            $stmt = $pdo->prepare("UPDATE vinos SET 
                nombre = ?, tipo_id = ?, region_id = ?, variedad_id = ?,
                crianza_id = ?, descripcion = ?, imagen = ?, precio = ?, precio_id = ?
                WHERE id = ?");
            $stmt->execute([$nombre, $tipo_id, $region_id, $variedad_id, $crianza_id,
                           $descripcion, $imagen, $precio, $precio_id, $_POST['id']]);
            $mensaje = "Producto actualizado correctamente";
        } else {
            // Insertar
            $stmt = $pdo->prepare("INSERT INTO vinos 
                (nombre, tipo_id, region_id, variedad_id, crianza_id, descripcion, imagen, precio, precio_id)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nombre, $tipo_id, $region_id, $variedad_id, $crianza_id,
                          $descripcion, $imagen, $precio, $precio_id]);
            $mensaje = "Producto agregado correctamente";
        }
    } catch (PDOException $e) {
        $error = "Error al guardar: " . $e->getMessage();
    }
}

// =============================== Manejar eliminación ===============================================
if (isset($_GET['eliminar'])) {
    try {
        $stmt = $pdo->prepare("DELETE FROM vinos WHERE id = ?");
        $stmt->execute([(int)$_GET['eliminar']]);
        $mensaje = "Producto eliminado correctamente";
        header("Location: editarproductos.php");
    } catch (PDOException $e) {
        $error = "Error al eliminar: " . $e->getMessage();
    }
}

// Obtener opciones para selects
$tipos = $pdo->query("SELECT * FROM tipos_vinos")->fetchAll();
$regiones = $pdo->query("SELECT * FROM regiones")->fetchAll();
$variedades = $pdo->query("SELECT * FROM variedades_uva")->fetchAll();
$crianzas = $pdo->query("SELECT * FROM crianzas")->fetchAll();
$precios = $pdo->query("SELECT * FROM precios_rango")->fetchAll();

// Obtener producto para editar
$edicion = [];
if (isset($_GET['editar'])) {
    $stmt = $pdo->prepare("SELECT * FROM vinos WHERE id = ?");
    $stmt->execute([(int)$_GET['editar']]);
    $edicion = $stmt->fetch();
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
                placeholder="Buscar vinos, regiones, variedades..."
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




<!-- Botones Iniciar Sesión, Registrarse y Carrito -->
<div class="col-lg-8 text-right d-flex justify-content-end align-items-center">
    <?php if(isset($_SESSION['username'])) : ?>
        <!-- Usuario logueado -->
        <div class="d-flex align-items-center mr-3">
            <i class='bx bx-user-circle h4 mb-0 mr-2 text-secondary'></i>
            <span class="mr-3"><?= htmlspecialchars($_SESSION['username']) ?></span>
            <a href="logout.php" class="btn btn-outline-dark">Salir</a>
        </div>
    <?php else : ?>
        <!-- Usuario no logueado -->
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

            <li class="nav-item">
              <a class="nav-link" href="index.php#quienes-somos">Quiénes somos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.php#contacto">Contacto</a>
            </li>
          </ul>
        </div>

      </div>
    </nav>
  </header>

<!--********************************************************************************************************** -->

    <main class="container my-5">
        <h1 class="mb-4">Administración de Productos</h1>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        
        <?php if (isset($mensaje)): ?>
            <div class="alert alert-success"><?= $mensaje ?></div>
        <?php endif; ?>

        <!-- Formulario de edición -->
        <div class="card mb-4">
            <div class="card-header">
                <?= empty($edicion) ? 'Agregar Nuevo Producto' : 'Editar Producto' ?>
            </div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $edicion['id'] ?? '' ?>">
                    <input type="hidden" name="imagen_actual" value="<?= $edicion['imagen'] ?? '' ?>">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" name="nombre" class="form-control" 
                                    value="<?= $edicion['nombre'] ?? '' ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Tipo de Vino</label>
                                <select name="tipo_id" class="form-control" required>
                                    <?php foreach ($tipos as $tipo): ?>
                                        <option value="<?= $tipo['id'] ?>" 
                                            <?= ($edicion['tipo_id'] ?? '') == $tipo['id'] ? 'selected' : '' ?>>
                                            <?= $tipo['nombre'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>Región</label>
                                <select name="region_id" class="form-control" required>
                                    <?php foreach ($regiones as $region): ?>
                                        <option value="<?= $region['id'] ?>" 
                                            <?= ($edicion['region_id'] ?? '') == $region['id'] ? 'selected' : '' ?>>
                                            <?= $region['nombre'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Variedad de Uva</label>
                                <select name="variedad_id" class="form-control" required>
                                    <?php foreach ($variedades as $variedad): ?>
                                        <option value="<?= $variedad['id'] ?>" 
                                            <?= ($edicion['variedad_id'] ?? '') == $variedad['id'] ? 'selected' : '' ?>>
                                            <?= $variedad['nombre'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>Crianza</label>
                                <select name="crianza_id" class="form-control" required>
                                    <?php foreach ($crianzas as $crianza): ?>
                                        <option value="<?= $crianza['id'] ?>" 
                                            <?= ($edicion['crianza_id'] ?? '') == $crianza['id'] ? 'selected' : '' ?>>
                                            <?= $crianza['nombre'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>Rango de Precio</label>
                                <select name="precio_id" class="form-control" required>
                                    <?php foreach ($precios as $precio): ?>
                                        <option value="<?= $precio['id'] ?>" 
                                            <?= ($edicion['precio_id'] ?? '') == $precio['id'] ? 'selected' : '' ?>>
                                            <?= $precio['etiqueta'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="3"><?= $edicion['descripcion'] ?? '' ?></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Precio (€)</label>
                                <input type="number" step="0.01" name="precio" class="form-control" 
                                    value="<?= $edicion['precio'] ?? '' ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Imagen</label>
                                <input type="file" name="imagen" class="form-control-file">
                                <?php if (!empty($edicion['imagen'])): ?>
                                    <small class="form-text text-muted">
                                        Actual: <a href="<?= $edicion['imagen'] ?>" target="_blank">Ver imagen</a>
                                    </small>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-wine">
                        <?= empty($edicion) ? 'Agregar Producto' : 'Actualizar Producto' ?>
                    </button>
                    
                    <?php if (!empty($edicion)): ?>
                        <a href="editarproductos.php" class="btn btn-secondary">Cancelar</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <!-- Lista de productos -->
        <div class="card">
            <div class="card-header">
                Listado de Productos
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Tipo</th>
                                <th>Región</th>
                                <th>Precio</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($vinos as $vino): ?>
                            <tr>
                                <td><?= $vino['nombre'] ?></td>
                                <td><?= $vino['tipo_nombre'] ?></td>
                                <td><?= $vino['region_nombre'] ?></td>
                                <td><?= $vino['precio'] ?>€</td>
                                <td>
                                    <a href="editarproductos.php?editar=<?= $vino['id'] ?>" 
                                       class="btn btn-sm btn-wine">Editar</a>
                                    <a href="editarproductos.php?eliminar=<?= $vino['id'] ?>" 
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('¿Seguro que deseas eliminar este producto?')">Eliminar</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
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
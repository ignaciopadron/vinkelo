<!-- Encabezado de sección -->
<div class="bg-light py-5">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0">
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>wines">Vinos</a></li>
                <?php if (isset($vino['tipo_nombre'])) : ?>
                    <li class="breadcrumb-item">
                        <a href="<?= BASE_URL ?>wines?filtro=4&id=<?= $vino['tipo_id'] ?>">
                            <?= htmlspecialchars($vino['tipo_nombre']) ?>
                        </a>
                    </li>
                <?php endif; ?>
                <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($vino['nombre']) ?></li>
            </ol>
        </nav>
    </div>
</div>

<!-- Detalle del vino -->
<div class="container py-5">
    <div class="row">
        <!-- Imagen del vino -->
        <div class="col-md-5 mb-4 mb-md-0">
            <div class="product-image-container bg-light rounded p-4 text-center">
                <?php if (!empty($vino['imagen'])) : ?>
                    <img src="<?= BASE_URL . $vino['imagen'] ?>" alt="<?= htmlspecialchars($vino['nombre']) ?>" class="img-fluid product-image">
                <?php else : ?>
                    <img src="<?= BASE_URL ?>assets/img/vino-default.jpg" alt="<?= htmlspecialchars($vino['nombre']) ?>" class="img-fluid product-image">
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Información del vino -->
        <div class="col-md-7">
            <h1 class="h2 mb-3"><?= htmlspecialchars($vino['nombre']) ?></h1>
            
            <!-- Badges -->
            <div class="mb-3">
                <?php if (isset($vino['tipo_nombre'])) : ?>
                    <span class="badge badge-primary mr-1"><?= htmlspecialchars($vino['tipo_nombre']) ?></span>
                <?php endif; ?>
                <?php if (isset($vino['region_nombre'])) : ?>
                    <span class="badge badge-info mr-1"><?= htmlspecialchars($vino['region_nombre']) ?></span>
                <?php endif; ?>
                <?php if (isset($vino['crianza_nombre'])) : ?>
                    <span class="badge badge-secondary"><?= htmlspecialchars($vino['crianza_nombre']) ?></span>
                <?php endif; ?>
            </div>
            
            <!-- Precio -->
            <div class="product-price mb-4">
                <span class="h3 text-wine font-weight-bold"><?= number_format($vino['precio'], 2, ',', '.') ?> €</span>
                <span class="text-muted ml-2">(IVA incluido)</span>
            </div>
            
            <!-- Descripción corta -->
            <div class="product-description mb-4">
                <p><?= nl2br(htmlspecialchars($vino['descripcion'])) ?></p>
            </div>
            
            <!-- Características -->
            <div class="product-features mb-4">
                <h5>Características</h5>
                <div class="row">
                    <div class="col-6">
                        <ul class="list-unstyled">
                            <?php if (isset($vino['variedad_nombre'])) : ?>
                                <li class="mb-2">
                                    <strong>Variedad:</strong> <?= htmlspecialchars($vino['variedad_nombre']) ?>
                                </li>
                            <?php endif; ?>
                            <?php if (isset($vino['region_nombre'])) : ?>
                                <li class="mb-2">
                                    <strong>Denominación:</strong> <?= htmlspecialchars($vino['region_nombre']) ?>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <div class="col-6">
                        <ul class="list-unstyled">
                            <?php if (isset($vino['tipo_nombre'])) : ?>
                                <li class="mb-2">
                                    <strong>Tipo:</strong> <?= htmlspecialchars($vino['tipo_nombre']) ?>
                                </li>
                            <?php endif; ?>
                            <?php if (isset($vino['crianza_nombre'])) : ?>
                                <li class="mb-2">
                                    <strong>Crianza:</strong> <?= htmlspecialchars($vino['crianza_nombre']) ?>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Añadir al carrito -->
            <div class="product-actions">
                <div class="d-flex align-items-center">
                    <div class="quantity-selector mr-3">
                        <div class="input-group" style="width: 130px;">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-secondary" type="button" id="decrementBtn">-</button>
                            </div>
                            <input type="number" class="form-control text-center" value="1" min="1" id="quantity">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="incrementBtn">+</button>
                            </div>
                        </div>
                    </div>
                    
                    <button class="btn btn-wine btn-lg add-to-cart" data-id="<?= $vino['id'] ?>">
                        <i class="bx bx-cart-add"></i> Añadir al carrito
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Tabs de información adicional -->
    <div class="product-tabs mt-5">
        <ul class="nav nav-tabs" id="productTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="maridaje-tab" data-toggle="tab" href="#maridaje" role="tab">
                    Maridaje
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="elaboracion-tab" data-toggle="tab" href="#elaboracion" role="tab">
                    Elaboración
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="bodega-tab" data-toggle="tab" href="#bodega" role="tab">
                    Bodega
                </a>
            </li>
        </ul>
        
        <div class="tab-content p-4 border border-top-0 rounded-bottom" id="productTabsContent">
            <div class="tab-pane fade show active" id="maridaje" role="tabpanel">
                <p>Este vino es ideal para acompañar platos de carne roja, asados, quesos curados y platos de caza.</p>
            </div>
            <div class="tab-pane fade" id="elaboracion" role="tabpanel">
                <p>Elaborado con uvas seleccionadas manualmente y fermentación controlada en tanques de acero inoxidable.</p>
            </div>
            <div class="tab-pane fade" id="bodega" role="tabpanel">
                <p>Bodega familiar con más de 50 años de tradición vinícola, situada en el corazón de la región.</p>
            </div>
        </div>
    </div>
    
    <!-- Productos relacionados -->
    <div class="related-products mt-5">
        <h3 class="mb-4">También te puede interesar</h3>
        
        <div class="row">
            <!-- Aquí se mostrarían productos relacionados -->
            <div class="col-6 col-md-3">
                <div class="wine-card card shadow-sm h-100">
                    <img src="<?= BASE_URL ?>assets/img/vino-default.jpg" alt="Vino relacionado" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">Vino relacionado 1</h5>
                        <p class="card-text">Breve descripción del vino relacionado...</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="price font-weight-bold">15,90 €</span>
                            <button class="btn btn-sm btn-wine">
                                <i class="bx bx-cart-add"></i> Añadir
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-6 col-md-3">
                <div class="wine-card card shadow-sm h-100">
                    <img src="<?= BASE_URL ?>assets/img/vino-default.jpg" alt="Vino relacionado" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">Vino relacionado 2</h5>
                        <p class="card-text">Breve descripción del vino relacionado...</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="price font-weight-bold">19,50 €</span>
                            <button class="btn btn-sm btn-wine">
                                <i class="bx bx-cart-add"></i> Añadir
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-6 col-md-3 d-none d-md-block">
                <div class="wine-card card shadow-sm h-100">
                    <img src="<?= BASE_URL ?>assets/img/vino-default.jpg" alt="Vino relacionado" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">Vino relacionado 3</h5>
                        <p class="card-text">Breve descripción del vino relacionado...</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="price font-weight-bold">22,75 €</span>
                            <button class="btn btn-sm btn-wine">
                                <i class="bx bx-cart-add"></i> Añadir
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-6 col-md-3 d-none d-md-block">
                <div class="wine-card card shadow-sm h-100">
                    <img src="<?= BASE_URL ?>assets/img/vino-default.jpg" alt="Vino relacionado" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">Vino relacionado 4</h5>
                        <p class="card-text">Breve descripción del vino relacionado...</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="price font-weight-bold">14,25 €</span>
                            <button class="btn btn-sm btn-wine">
                                <i class="bx bx-cart-add"></i> Añadir
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript para el selector de cantidad -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const quantityInput = document.getElementById('quantity');
    const decrementBtn = document.getElementById('decrementBtn');
    const incrementBtn = document.getElementById('incrementBtn');
    
    decrementBtn.addEventListener('click', function() {
        const currentValue = parseInt(quantityInput.value);
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
        }
    });
    
    incrementBtn.addEventListener('click', function() {
        const currentValue = parseInt(quantityInput.value);
        quantityInput.value = currentValue + 1;
    });
});
</script> 
<?php
/**
 * Componente de tarjeta de vino
 * 
 * Recibe:
 * - $vino: Array con datos del vino
 */
?>
<div class="wine-card card shadow-sm h-100">
    <div class="wine-card-img-container">
        <?php if (!empty($vino['imagen'])) : ?>
            <img src="<?= BASE_URL . $vino['imagen'] ?>" alt="<?= htmlspecialchars($vino['nombre']) ?>" class="card-img-top">
        <?php else : ?>
            <img src="<?= BASE_URL ?>assets/img/vino-default.jpg" alt="<?= htmlspecialchars($vino['nombre']) ?>" class="card-img-top">
        <?php endif; ?>
    </div>
    <div class="card-body d-flex flex-column">
        <!-- Tipos y categorías -->
        <div class="mb-2">
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
        
        <!-- Título -->
        <h5 class="card-title"><?= htmlspecialchars($vino['nombre']) ?></h5>
        
        <!-- Variedad -->
        <?php if (isset($vino['variedad_nombre'])) : ?>
            <p class="card-text text-muted small">
                <i class="bx bx-wine"></i> <?= htmlspecialchars($vino['variedad_nombre']) ?>
            </p>
        <?php endif; ?>
        
        <!-- Descripción corta -->
        <p class="card-text flex-grow-1">
            <?= substr(htmlspecialchars($vino['descripcion']), 0, 100) ?>...
        </p>
        
        <!-- Footer de tarjeta con precio y botón -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <span class="price font-weight-bold"><?= number_format($vino['precio'], 2, ',', '.') ?> €</span>
            <div>
                <a href="<?= BASE_URL ?>wine/<?= $vino['id'] ?>" class="btn btn-sm btn-outline-secondary mr-1">
                    <i class="bx bx-info-circle"></i>
                </a>
                <button class="btn btn-sm btn-wine add-to-cart" data-id="<?= $vino['id'] ?>">
                    <i class="bx bx-cart-add"></i> Añadir
                </button>
            </div>
        </div>
    </div>
</div> 
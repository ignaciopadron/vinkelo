<!-- Encabezado de sección -->
<div class="bg-light py-5">
    <div class="container">
        <h1 class="display-4"><?= $titulo ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0">
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Vinos</li>
                <?php if ($filtro) : ?>
                    <li class="breadcrumb-item active" aria-current="page"><?= $titulo ?></li>
                <?php endif; ?>
            </ol>
        </nav>
    </div>
</div>

<!-- Listado de vinos -->
<div class="container py-5">
    
    <!-- Filtros móviles (ocultos en desktop) -->
    <div class="d-lg-none mb-4">
        <button class="btn btn-outline-secondary w-100" type="button" data-toggle="collapse" data-target="#mobileFilters">
            <i class="bx bx-filter-alt"></i> Filtros
        </button>
        
        <div class="collapse mt-3" id="mobileFilters">
            <div class="card card-body">
                <!-- Filtros móviles -->
                <div class="mb-3">
                    <h6>Tipo de vino</h6>
                    <div class="list-group list-group-flush">
                        <a href="<?= BASE_URL ?>wines?filtro=4&id=1" class="list-group-item list-group-item-action small">Tinto</a>
                        <a href="<?= BASE_URL ?>wines?filtro=4&id=2" class="list-group-item list-group-item-action small">Blanco</a>
                        <a href="<?= BASE_URL ?>wines?filtro=4&id=3" class="list-group-item list-group-item-action small">Rosado</a>
                    </div>
                </div>
                
                <div class="mb-3">
                    <h6>Denominación de origen</h6>
                    <div class="list-group list-group-flush">
                        <a href="<?= BASE_URL ?>wines?filtro=2&id=1" class="list-group-item list-group-item-action small">La Rioja</a>
                        <a href="<?= BASE_URL ?>wines?filtro=2&id=2" class="list-group-item list-group-item-action small">Ribera del Duero</a>
                        <a href="<?= BASE_URL ?>wines?filtro=2&id=3" class="list-group-item list-group-item-action small">Jumilla</a>
                    </div>
                </div>
                
                <div>
                    <h6>Envejecimiento</h6>
                    <div class="list-group list-group-flush">
                        <a href="<?= BASE_URL ?>wines?filtro=3&id=1" class="list-group-item list-group-item-action small">Joven</a>
                        <a href="<?= BASE_URL ?>wines?filtro=3&id=2" class="list-group-item list-group-item-action small">Roble</a>
                        <a href="<?= BASE_URL ?>wines?filtro=3&id=3" class="list-group-item list-group-item-action small">Crianza</a>
                        <a href="<?= BASE_URL ?>wines?filtro=3&id=4" class="list-group-item list-group-item-action small">Reserva</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Filtros (solo desktop) -->
        <div class="col-lg-3 d-none d-lg-block">
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Filtros</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6>Tipo de vino</h6>
                        <div class="list-group list-group-flush">
                            <a href="<?= BASE_URL ?>wines?filtro=4&id=1" class="list-group-item list-group-item-action">Tinto</a>
                            <a href="<?= BASE_URL ?>wines?filtro=4&id=2" class="list-group-item list-group-item-action">Blanco</a>
                            <a href="<?= BASE_URL ?>wines?filtro=4&id=3" class="list-group-item list-group-item-action">Rosado</a>
                            <a href="<?= BASE_URL ?>wines?filtro=4&id=4" class="list-group-item list-group-item-action">Dulce</a>
                            <a href="<?= BASE_URL ?>wines?filtro=4&id=6" class="list-group-item list-group-item-action">Cava</a>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h6>Denominación de origen</h6>
                        <div class="list-group list-group-flush">
                            <a href="<?= BASE_URL ?>wines?filtro=2&id=1" class="list-group-item list-group-item-action">La Rioja</a>
                            <a href="<?= BASE_URL ?>wines?filtro=2&id=2" class="list-group-item list-group-item-action">Ribera del Duero</a>
                            <a href="<?= BASE_URL ?>wines?filtro=2&id=3" class="list-group-item list-group-item-action">Jumilla</a>
                            <a href="<?= BASE_URL ?>wines?filtro=2&id=4" class="list-group-item list-group-item-action">Calatayud</a>
                            <a href="<?= BASE_URL ?>wines?filtro=2&id=5" class="list-group-item list-group-item-action">Pago de Vallegarcía</a>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h6>Variedad de uva</h6>
                        <div class="list-group list-group-flush">
                            <a href="<?= BASE_URL ?>wines?filtro=1&id=1" class="list-group-item list-group-item-action">Verdejo</a>
                            <a href="<?= BASE_URL ?>wines?filtro=1&id=2" class="list-group-item list-group-item-action">Sauvignon Blanc</a>
                            <a href="<?= BASE_URL ?>wines?filtro=1&id=3" class="list-group-item list-group-item-action">Tempranillo</a>
                            <a href="<?= BASE_URL ?>wines?filtro=1&id=4" class="list-group-item list-group-item-action">Garnacha</a>
                        </div>
                    </div>
                    
                    <div>
                        <h6>Envejecimiento</h6>
                        <div class="list-group list-group-flush">
                            <a href="<?= BASE_URL ?>wines?filtro=3&id=1" class="list-group-item list-group-item-action">Joven</a>
                            <a href="<?= BASE_URL ?>wines?filtro=3&id=2" class="list-group-item list-group-item-action">Roble</a>
                            <a href="<?= BASE_URL ?>wines?filtro=3&id=3" class="list-group-item list-group-item-action">Crianza</a>
                            <a href="<?= BASE_URL ?>wines?filtro=3&id=4" class="list-group-item list-group-item-action">Reserva</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Listado de vinos -->
        <div class="col-lg-9">
            <?php if (empty($vinos)) : ?>
                <div class="alert alert-info">
                    No se encontraron vinos que coincidan con los filtros seleccionados.
                </div>
            <?php else : ?>
                <div class="row">
                    <?php foreach ($vinos as $vino) : ?>
                        <div class="col-6 col-md-4 mb-4">
                            <?php include APP_PATH . '/views/components/wine-card.php'; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Paginación -->
                <?php if ($total_paginas > 1) : ?>
                    <nav aria-label="Paginación" class="mt-4">
                        <ul class="pagination justify-content-center">
                            <?php if ($pagina_actual > 1) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?= BASE_URL ?>wines?<?= $filtro ? "filtro={$filtro}&id={$id}&" : "" ?>page=<?= $pagina_actual - 1 ?>">
                                        <i class="bx bx-chevron-left"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                            
                            <?php for ($i = 1; $i <= $total_paginas; $i++) : ?>
                                <li class="page-item <?= $i === $pagina_actual ? 'active' : '' ?>">
                                    <a class="page-link" href="<?= BASE_URL ?>wines?<?= $filtro ? "filtro={$filtro}&id={$id}&" : "" ?>page=<?= $i ?>">
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                            
                            <?php if ($pagina_actual < $total_paginas) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?= BASE_URL ?>wines?<?= $filtro ? "filtro={$filtro}&id={$id}&" : "" ?>page=<?= $pagina_actual + 1 ?>">
                                        <i class="bx bx-chevron-right"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div> 
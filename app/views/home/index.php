<!-- Hero Section -->
<section class="hero-section">
    <div class="container h-100 d-flex align-items-center">
        <div class="row">
            <div class="col-md-6 text-white">
                <h1 class="display-4 font-weight-bold mb-4">Descubre el mundo del vino</h1>
                <p class="lead mb-4">
                    Encuentra los mejores vinos de España seleccionados especialmente para ti.
                </p>
                <a href="<?= BASE_URL ?>wines" class="btn btn-lg btn-wine px-4">
                    Ver catálogo
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Vinos Tintos -->
<section class="category-section py-5" id="tintos">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title">Vinos Tintos</h2>
            <a href="<?= BASE_URL ?>wines?filtro=4&id=1" class="btn btn-outline-secondary">
                Ver todos <i class='bx bx-right-arrow-alt'></i>
            </a>
        </div>
        
        <div class="row">
            <?php foreach ($vinos_tintos as $vino) : ?>
                <div class="col-6 col-md-3 mb-4">
                    <?php 
                        // Incluir el componente de tarjeta de vino
                        include APP_PATH . '/views/components/wine-card.php';
                    ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Vinos Blancos -->
<section class="category-section py-5 bg-light" id="blancos">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title">Vinos Blancos</h2>
            <a href="<?= BASE_URL ?>wines?filtro=4&id=2" class="btn btn-outline-secondary">
                Ver todos <i class='bx bx-right-arrow-alt'></i>
            </a>
        </div>
        
        <div class="row">
            <?php foreach ($vinos_blancos as $vino) : ?>
                <div class="col-6 col-md-3 mb-4">
                    <?php 
                        // Incluir el componente de tarjeta de vino
                        include APP_PATH . '/views/components/wine-card.php';
                    ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Vinos Rosados -->
<section class="category-section py-5" id="rosados">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title">Vinos Rosados</h2>
            <a href="<?= BASE_URL ?>wines?filtro=4&id=3" class="btn btn-outline-secondary">
                Ver todos <i class='bx bx-right-arrow-alt'></i>
            </a>
        </div>
        
        <div class="row">
            <?php foreach ($vinos_rosados as $vino) : ?>
                <div class="col-6 col-md-3 mb-4">
                    <?php 
                        // Incluir el componente de tarjeta de vino
                        include APP_PATH . '/views/components/wine-card.php';
                    ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Quiénes Somos -->
<section id="quienes-somos" class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5">Quiénes Somos</h2>
        
        <div class="story__container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="story__images text-center">
                        <img src="<?= BASE_URL ?>assets/img/about-us.jpg" alt="Viñedos" class="img-fluid rounded shadow">
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="story__description">
                        <h3 class="mb-4">Nuestra historia</h3>
                        <p>
                            En <strong>Vinkelo</strong> somos apasionados del vino y de la cultura que lo rodea. 
                            Fundada en 2020, nuestra misión es acercar los mejores vinos españoles a todos 
                            los amantes del buen beber.
                        </p>
                        <p>
                            Trabajamos directamente con pequeñas y medianas bodegas que cuidan cada detalle 
                            del proceso de elaboración, desde la viña hasta la botella.
                        </p>
                        
                        <h4 class="mt-4">Nuestros principios:</h4>
                        <ul>
                            <li>Selección rigurosa de vinos de calidad</li>
                            <li>Apoyo a productores locales</li>
                            <li>Precios justos</li>
                            <li>Asesoramiento personalizado</li>
                            <li>Sostenibilidad y respeto por el medio ambiente</li>
                        </ul>
                        
                        <a href="<?= BASE_URL ?>about" class="btn btn-wine mt-3">Conocer más</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Sección Contacto -->
<section class="contact-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <div class="card shadow">
                    <div class="card-body p-5">
                        <h3 class="card-title text-center mb-4">Contacta con nosotros</h3>
                        
                        <form action="#" method="POST">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="asunto">Asunto</label>
                                <input type="text" class="form-control" id="asunto" name="asunto" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="mensaje">Mensaje</label>
                                <textarea class="form-control" id="mensaje" name="mensaje" rows="4" required></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-wine btn-block">Enviar mensaje</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> 
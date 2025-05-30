  </main>

  <!-- Footer -->
  <footer class="footer bg-dark text-white pt-5 pb-4 mt-5">
    <div class="container">
      <div class="row">
        
        <!-- Logo y descripción -->
        <div class="col-md-4 mb-4">
          <img 
            src="<?= BASE_URL ?>assets/img/logo_vinnkelo_vectorizado.svg" 
            alt="Logo Vinkelo" 
            style="width: 150px; height: auto; filter: brightness(0) invert(1);"
            class="img-fluid mb-3">
          <p class="text-muted">
            Distribuidores de vinos de calidad. Seleccionamos las mejores bodegas
            de España para ofrecerte vinos con personalidad y carácter.
          </p>
        </div>
        
        <!-- Enlaces rápidos -->
        <div class="col-md-2 mb-4">
          <h5 class="text-uppercase mb-4">Enlaces</h5>
          <ul class="list-unstyled">
            <li><a href="<?= BASE_URL ?>" class="text-muted">Home</a></li>
            <li><a href="<?= BASE_URL ?>wines" class="text-muted">Vinos</a></li>
            <li><a href="<?= BASE_URL ?>about" class="text-muted">Quiénes somos</a></li>
            <li><a href="<?= BASE_URL ?>contact" class="text-muted">Contacto</a></li>
          </ul>
        </div>
        
        <!-- Categorías -->
        <div class="col-md-3 mb-4">
          <h5 class="text-uppercase mb-4">Categorías</h5>
          <ul class="list-unstyled">
            <li><a href="<?= BASE_URL ?>wines?filtro=4&id=1" class="text-muted">Vinos tintos</a></li>
            <li><a href="<?= BASE_URL ?>wines?filtro=4&id=2" class="text-muted">Vinos blancos</a></li>
            <li><a href="<?= BASE_URL ?>wines?filtro=4&id=3" class="text-muted">Vinos rosados</a></li>
            <li><a href="<?= BASE_URL ?>wines?filtro=4&id=6" class="text-muted">Cavas</a></li>
          </ul>
        </div>
        
        <!-- Contacto -->
        <div class="col-md-3 mb-4">
          <h5 class="text-uppercase mb-4">Contacto</h5>
          <ul class="list-unstyled">
            <li class="mb-2">
              <i class='bx bx-map mr-2'></i>
              <span class="text-muted">Calle Vino, 123, Madrid</span>
            </li>
            <li class="mb-2">
              <i class='bx bx-phone mr-2'></i>
              <span class="text-muted">+34 912 345 678</span>
            </li>
            <li class="mb-2">
              <i class='bx bx-envelope mr-2'></i>
              <span class="text-muted">info@vinkelo.com</span>
            </li>
          </ul>
          
          <!-- Redes sociales -->
          <div class="mt-4">
            <a href="#" class="text-white mr-3 h4">
              <i class='bx bxl-facebook-circle'></i>
            </a>
            <a href="#" class="text-white mr-3 h4">
              <i class='bx bxl-instagram'></i>
            </a>
            <a href="#" class="text-white mr-3 h4">
              <i class='bx bxl-twitter'></i>
            </a>
          </div>
        </div>
        
      </div>
      
      <hr class="bg-secondary">
      
      <!-- Copyright -->
      <div class="row">
        <div class="col-md-6 text-center text-md-left">
          <p class="text-muted mb-0">
            &copy; <?= date('Y') ?> Vinkelo. Todos los derechos reservados.
          </p>
        </div>
        <div class="col-md-6 text-center text-md-right">
          <p class="text-muted mb-0">
            <a href="#" class="text-muted">Política de privacidad</a> | 
            <a href="#" class="text-muted">Términos y condiciones</a>
          </p>
        </div>
      </div>
    </div>
  </footer>

  <!-- Botón WhatsApp flotante -->
  <a href="https://wa.me/34912345678" class="whatsapp-btn" target="_blank">
    <i class='bx bxl-whatsapp'></i>
  </a>

  <!-- JavaScript -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="<?= BASE_URL ?>assets/js/main.js"></script>
</body>
</html> 
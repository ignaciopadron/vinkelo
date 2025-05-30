# Política de Seguridad

## Configuración Segura

### Archivos de Configuración

- **No incluyas** credenciales reales en los archivos de configuración que se suben a GitHub.
- Usa siempre el archivo `app/config/config.example.php` como plantilla, copiándolo a `config.php` con tus propias credenciales.
- El archivo `config.php` está incluido en `.gitignore` para evitar que se suba accidentalmente.

### Manejo de Claves

- No guardes contraseñas, tokens de API, u otras claves directamente en el código.
- Usa variables de entorno o archivos de configuración excluidos del control de versiones.

## Buenas Prácticas para Contribuidores

### Al escribir código

1. **Sanitiza las entradas**: Todos los datos de entrada deben ser validados y sanitizados.
   ```php
   $entrada = sanitizarInput($_POST['dato']);
   ```

2. **Usa consultas preparadas**: Nunca insertes valores directamente en consultas SQL.
   ```php
   // ❌ INSEGURO:
   $query = "SELECT * FROM usuarios WHERE username = '$username'";
   
   // ✅ SEGURO:
   $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = :username");
   $stmt->execute([':username' => $username]);
   ```

3. **Escapa salidas**: Asegúrate de escapar adecuadamente datos antes de mostrarlos.
   ```php
   echo htmlspecialchars($dato);
   ```

4. **Permisos y autenticación**: Verifica siempre los permisos antes de realizar acciones sensibles.
   ```php
   if (!isAdmin()) {
       redirect('login');
   }
   ```

### Al subir cambios

1. Asegúrate de que no incluyes archivos de configuración con credenciales reales.
2. Evita subir archivos temporales, logs, o datos sensibles.
3. Realiza un `git diff` antes de confirmar cambios para verificar lo que estás enviando.

## Vulnerabilidades Conocidas

Si descubres una vulnerabilidad de seguridad, por favor NO la reportes públicamente en los issues de GitHub.

En su lugar, envía un correo electrónico a [seguridad@vinkelo.com] con los detalles. Intentaremos resolver la vulnerabilidad lo antes posible. 
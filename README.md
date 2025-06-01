# Vinkelo 🍷 

Vinkelo es una aplicación web para la gestión y presentación de un catálogo de vinos, diseñada con un enfoque MVC (Modelo-Vista-Controlador) y siguiendo buenas prácticas de desarrollo.

![Página de inicio de Vinkelo](public/assets/img/freepik_fondo_home.png)
*Imagen creada con la suite creativa de IA de Freepik*

## 📜 Tabla de Contenidos

- [Características](#-características)
- [Arquitectura](#-arquitectura)
- [Requisitos](#-requisitos)
- [Instalación](#-instalación)
- [Configuración](#-configuración)
- [Ejecución](#-ejecución)
- [Uso](#-uso)
- [Seguridad](#-seguridad)
- [Contribuir](#-contribuir)
- [Licencia](#-licencia)

## ✨ Características

- **Catálogo completo**: Visualización de productos con filtros por tipo, variedad, región y crianza
- **Sistema de usuarios**: Roles diferenciados (administrador y usuario normal)
- **Panel de administración**: Interfaz para gestionar el catálogo de productos
- **Diseño responsive**: Adaptado a dispositivos móviles y desktop
- **Carrito de compra**: Gestión del carrito mediante JavaScript
- **Buscador integrado**: Búsqueda de productos por diversos criterios

## 🏗️ Arquitectura

El proyecto sigue una arquitectura MVC (Modelo-Vista-Controlador) para separar responsabilidades:

```
vinkelo/
├── public/                     # Contenido público accesible
│   ├── index.php               # Punto de entrada único
│   └── assets/                 # Recursos estáticos
│       ├── css/                # Hojas de estilo
│       ├── js/                 # JavaScript
│       └── img/                # Imágenes y logos
│
├── app/                        # Código de la aplicación
│   ├── config/                 # Configuración
│   ├── controllers/            # Controladores
│   ├── models/                 # Modelos
│   ├── views/                  # Vistas
│   │   ├── components/         # Componentes reutilizables
│   │   └── [secciones]/        # Vistas específicas
│   ├── helpers/                # Funciones auxiliares
│   └── database/               # Scripts de base de datos
│
└── .htaccess                   # Configuración de Apache
```

## 📋 Requisitos

- PHP 7.4 o superior
- MySQL/MariaDB
- Servidor web Apache con mod_rewrite habilitado
- Extensiones PHP: PDO, mysqli, mbstring, gd

## 🚀 Instalación

1. **Clonar el repositorio**:
   ```bash
   git clone https://github.com/ipadron/vinkelo.git
   cd vinkelo
   ```

2. **Configurar la base de datos**:
   - Crear una base de datos en MySQL/MariaDB
   - Importar el archivo de estructura:
     ```bash
     mysql -u usuario -p vinkelo < app/database/vinkelo.sql
     ```

3. **Configurar permisos**:
   ```bash
   chmod -R 755 public/uploads/
   ```

## ⚙️ Configuración

1. **Configuración de la base de datos**:
   - Copiar el archivo de configuración de ejemplo:
     ```bash
     cp app/config/config.example.php app/config/config.php
     ```
   - Editar `app/config/config.php` con tus credenciales:
     ```php
     define('DB_HOST', 'localhost');
     define('DB_USER', 'tu_usuario');
     define('DB_PASS', 'tu_password');
     define('DB_NAME', 'vinkelo');
     ```

2. **Configuración del servidor web**:
   - Asegurarse de que el servidor web apunta al directorio `public/`
   - Verificar que mod_rewrite está habilitado en Apache

## 🏃‍♂️ Ejecución

### Servidor de desarrollo integrado en PHP

Para entornos de desarrollo, puedes usar el servidor web integrado de PHP:

```bash
cd /ruta/a/vinkelo
php -S localhost:8000 -t public
```

Luego, abre http://localhost:8000 en tu navegador.

### Servidor Apache

1. Configura un VirtualHost apuntando al directorio `public/`
2. Asegúrate de que mod_rewrite está habilitado
3. Accede a través de la URL configurada

## 💻 Uso

### Panel de Administración

Para acceder al panel de administración:
1. Inicia sesión con una cuenta de administrador
2. Navega a `/admin` o haz clic en el enlace "Administración" en el menú

Desde el panel de administración podrás:
- Ver todos los vinos
- Añadir nuevos vinos
- Editar vinos existentes
- Eliminar vinos

### Catálogo Público

El catálogo público permite:
- Navegar por todos los vinos
- Filtrar por tipo, variedad, región y crianza
- Ver detalles de cada vino
- Añadir vinos al carrito
- Buscar vinos por términos específicos

## 🔒 Seguridad

Este proyecto sigue las siguientes prácticas de seguridad:

1. **Datos sensibles**: Las credenciales se almacenan en archivos excluidos del control de versiones
2. **Protección contra SQL Injection**: Uso de consultas preparadas (PDO)
3. **Protección XSS**: Sanitización de datos de entrada y salida
4. **Sesiones seguras**: Gestión de sesiones con protecciones contra ataques comunes
5. **Acceso a archivos**: Estructura que limita el acceso directo a archivos sensibles

Para más detalles, consulta el archivo [SECURITY.md](SECURITY.md).

## 🤝 Contribuir

Las contribuciones son bienvenidas. Para contribuir:

1. Haz un fork del proyecto
2. Crea una rama para tu característica (`git checkout -b feature/amazing-feature`)
3. Haz commit de tus cambios (`git commit -m 'Add: amazing feature'`)
4. Sube la rama (`git push origin feature/amazing-feature`)
5. Abre un Pull Request

## Descripción

Desarrollo de Prueba Técnica para Monoma Technology

En esta prueba técnica, se ha desarrollado una solución para Monoma Technology que incluye la creación de cuatro endpoints con diversas validaciones. A continuación, se destacan las herramientas y habilidades utilizadas:

- Arquitectura Hexagonal con Laravel: Implementación de una arquitectura hexagonal basada en puertos y adaptadores, permitiendo una separación clara entre la lógica de dominio y las interfaces externas.

- Uso de Redis para Cacheo: Implementación de Redis como sistema de caché para optimizar el rendimiento y reducir el tiempo de respuesta en las consultas a los endpoints, asegurando una recuperación rápida de datos.

- Pruebas Unitarias: Desarrollo de pruebas unitarias para validar el correcto funcionamiento de los endpoints. Las pruebas se realizan utilizando Postman, garantizando que todas las funcionalidades estén correctamente verificadas y se comporten como se espera.

- Factories en Modelos: Empleo de factories para la generación de datos ficticios en los modelos, facilitando el desarrollo y las pruebas sin necesidad de datos reales.

- Seeders para Creación de Usuarios: Utilización de seeders para crear usuarios y otros datos necesarios en la base de datos, simplificando la configuración inicial del entorno de desarrollo.

- Buenas Prácticas de Programación: Aplicación de buenas prácticas de programación para asegurar un código limpio, mantenible y escalable. Esto incluye la implementación de patrones de diseño adecuados y la adherencia a estándares de codificación.

## Tecnología

[Laravel 10.0](https://laravel.com/) Estructura genérica PHP.  
[PHP 8.2.7](https://www.php.net/) PHP: Hypertext Preprocessor.  
[Composer 2.7.6](https://getcomposer.org/) Administrador de dependencias para PHP.

## Configuración para correr los seeders y test unitarios
```bash
php artisan migrate:fresh --seed
php artisan test
```

## Instalación

```bash
$ composer install
```

## Configuración: env

```bash
# Configuracion requerida  
  
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:l6zHhvGh57cs9fo6jPWVIh+vMT+u5FSz5pWOQniC3gg=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestion_candidatos
DB_USERNAME=root
DB_PASSWORD=12345678

BROADCAST_DRIVER=log
CACHE_DRIVER=redis
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
REDIS_CLIENT=phpredis

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

JWT_SECRET=t5NSFWrJy2SVpZIIOzCuOXUCYKh49LnuymkKh7iQZJwZq4mQxq7qC3z1yvaTRoWF

TOKEN_EXPIRATION_MINUTES=1440
```

## Configuración: env testing
```bash
DB_CONNECTION=mysql
DB_DATABASE=gestion_candidatos
DB_USERNAME=root
DB_PASSWORD=12345678
```

## Ejecución de la aplicación

```bash
$ php artisan serve
# http://127.0.0.1:8000
```

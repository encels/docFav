# docFav

# Proyecto de Gestión de Usuarios

Este proyecto es una aplicación de gestión de usuarios que utiliza PHP y Doctrine ORM para la persistencia de datos. Está diseñado para almacenar y gestionar información de usuarios, incluyendo la creación, búsqueda y validación de usuarios a través de un sistema seguro que protege las contraseñas.

## Características

- **Gestión de Usuarios**: Permite crear, leer, actualizar y eliminar usuarios.
- **Validación de Contraseñas**: Asegura que las contraseñas cumplan con criterios de seguridad (longitud mínima, caracteres especiales, etc.).
- **Uso de Value Objects**: Implementa Value Objects para encapsular propiedades como `Email`, `Password`, `UserId`, y `Name`, promoviendo un diseño orientado a objetos y la consistencia de datos Claves.
- **Tipos Personalizados de Doctrine**: Utiliza tipos personalizados de Doctrine para manejar objetos de valor, facilitando su almacenamiento en la base de datos.
- **Pruebas de Integración**: Incluye pruebas unitarias y pruebas de integración para asegurar que las funcionalidades de gestión de usuarios operen correctamente.

## Tecnologías Utilizadas

- **PHP**: Lenguaje de programación principal.
- **Doctrine ORM**: Para la gestión de la persistencia de datos.
- **MySQL**: Base de datos para almacenar la información de los usuarios.
- **Composer**: Para la gestión de dependencias.

## Instalación

1. Clona el repositorio:
   ```bash
   git clone https://github.com/encels/docFav.git


2. Para correr el proyecto ejecuta los siguientes comandos

```bash
# Start the Docker containers
make up

# Build the Docker containers
make build

# Install Composer dependencies
make install

# Create the database
make schema-create

# (Optional) Update the database
make schema-update

# Run tests
make test
```
## Prueba de API

Para realizar pruebas en la API, puedes utilizar el siguiente comando `curl`:

```bash
curl --location 'http://localhost:8080/index.php' \
--header 'Content-Type: application/json' \
--data-raw '{
    "name": "Juan Pérez",
    "email": "juan.perez2025@example.com",
    "password": "Tucontraseñasegura1"
}'
```

## Descripción del Request

- **URL**: `http://localhost:8080/index.php`
- **Método**: POST
- **Encabezado**: 
  - `Content-Type: application/json`
- **Cuerpo**: 
  ```json
  {
      "name": "Juan Parez",
      "email": "juan.perez2025@example.com",
      "password": "Tucontraseñasegura1"
  }
  ```
# 🔐 API CRUD Segura con JWT, PHP y MySQL

API REST desarrollada en **PHP Orientado a Objetos** que implementa autenticación mediante **JSON Web Token (JWT)**, protección de rutas, gestión segura de contraseñas con **password_hash()** y **password_verify()**, y operaciones CRUD sobre una base de datos MySQL utilizando **PDO**.

## 📋 Características

- Autenticación mediante JWT.
- Contraseñas encriptadas con `PASSWORD_BCRYPT`.
- Validación de tokens antes de acceder a los recursos.
- CRUD completo protegido por JWT.
- Arquitectura orientada a objetos.
- Uso de Composer para la gestión de dependencias.
- Conexión segura a MySQL mediante PDO.
- Respuestas en formato JSON.
- Front Controller para centralizar las peticiones.

---

# 🛠 Tecnologías utilizadas

- PHP 8+
- MySQL
- PDO
- Composer
- Firebase PHP-JWT
- Postman
- JSON

---

# 📁 Estructura del proyecto

```
JWT_API/
│
├── api/
│
├── config/
│   └── config.php
│
├── src/
│   ├── AuthService.php
│   ├── DB.php
│   └── ProductController.php
│
├── vendor/
│
├── .gitignore
├── composer.json
├── composer.lock
├── generarhash.php
├── login.php
└── index.php
```

---

# 📦 Instalación

## 1. Clonar el repositorio

```bash
git clone <URL_DEL_REPOSITORIO>
```

---

## 2. Instalar dependencias

Dentro de la carpeta del proyecto ejecutar:

```bash
composer install
```

---

## 3. Crear la base de datos

```sql
CREATE DATABASE jwt_api;
```

---

## 4. Crear la tabla de usuarios

```sql
CREATE TABLE usuarios(
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);
```

---

## 5. Crear la tabla de productos

```sql
CREATE TABLE productos(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    precio DECIMAL(10,2) NOT NULL
);
```

---

## 6. Configurar credenciales

Crear el archivo:

```
config/config.php
```

```php
<?php

define("DB_HOST","localhost");
define("DB_NAME","jwt_api");
define("DB_USER","root");
define("DB_PASS","");

define(
    "JWT_SECRET_KEY",
    "UnaClaveMuyLargaYSeguraDeMasDe32CaracteresParaJWT"
);
```

Este archivo no debe subirse al repositorio.

---

# 🔒 Seguridad

Las contraseñas nunca se almacenan en texto plano.

Para generar un hash:

```php
password_hash("admin123", PASSWORD_BCRYPT);
```

Para verificar:

```php
password_verify($password, $hash);
```

---

# 📦 Dependencias

Instalar Firebase JWT:

```bash
composer require firebase/php-jwt
```

---

# 🚀 Autenticación

## Login

**POST**

```
http://localhost/JWT_API/login.php
```

Body (form-data)

| Campo | Valor |
|--------|--------|
| usuario | admin |
| password | admin123 |

Respuesta:

```json
{
    "success": true,
    "token": "eyJhbGc..."
}
```

---

# 🔑 Uso del Token

Todas las peticiones al CRUD deben incluir el Header:

```
Authorization: Bearer TU_TOKEN
```

---

# 📚 Endpoints

## Obtener productos

```
GET /index.php
```

---

## Registrar producto

```
POST /index.php
```

Body (JSON)

```json
{
    "nombre":"Laptop",
    "precio":2500
}
```

---

## Actualizar producto

```
PUT /index.php
```

Body

```json
{
    "id":1,
    "nombre":"Laptop Gamer",
    "precio":3200
}
```

---

## Eliminar producto

```
DELETE /index.php
```

Body

```json
{
    "id":1
}
```

---

# 🧪 Pruebas en Postman

## Escenario Negativo

Realizar una petición sin token.

Resultado esperado:

```
401 Unauthorized
```

```json
{
    "success": false,
    "message": "Token requerido"
}
```

---

## Escenario Positivo

1. Iniciar sesión.
2. Obtener el JWT.
3. Enviar el token en el Header.
4. Realizar operaciones GET, POST, PUT y DELETE correctamente.

---

# 📂 Dependencias ignoradas

El archivo `.gitignore` contiene:

```
/vendor/
/config/config.php
```

---

# 👨‍💻 Autor

**Ian Torres**

Licenciatura en Desarrollo y Gestión de Software

Universidad Tecnológica de Panamá

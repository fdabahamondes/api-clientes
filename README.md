#   Proyecto Backend - Evaluación I y II - API REST con Docker y Laravel

**Integrante:** Fernanda Bahamondes
**Asignatura:** Desarrollo de Backend - Sección 50
**Repositorio GitHub:** https://github.com/fdabahamondes/api-clientes

---

# ÍNDICE DEL DOCUMENTO

**Evaluación 1:** **Inicia en línea 16 - Finaliza en línea 356**
**Evaluación 2:** **Inicia en línea 361 - Finaliza en línea 907**

--- 

# EVALUACIÓN N°1 - API REST con Docker y Laravel

--- 

#   INTRODUCCIÓN DEL PROYECTO 

Este proyecto consiste en el desarrollo de una API REST básica para la gestión de clientes,
implementada con Laravel y un entorno contenerizado usando Docker. 

El sistema permite: 
- Verificar el estado del backend
- Crear, listar, actualizar y eliminar clientes (CRUD)
- Validar la comunicación entre backend y la base de datos 

El objetivo principal es demostrar que la arquitectura backend funciona correctamente 
usando MVC, junto con la persistencia de datos y un entorno de trabajo portable 
gracias a Docker.  

--- 

#   TECNOLOGÍAS UTILIZADAS 

- PHP 8.2 (Lenguaje backend)
- Laravel (Framework MVC)
- MySQL (Base de datos)
- Nginx (Servidor web)
- Docker / Docker Compose (Contenerización)
- Postman (Prueba de API)

--- 

#   ARQUITECTURA DEL SISTEMA (MVC + DOCKER)

El sistema está compuesto por 3 servicios principales:

- **Nginx:** Recibe las solicitudes HTTP del cliente
- **Laravel (PHP-FPM):** Procesa la lógica de negocio bajo arquitectura MVC
- **MySQL:** Almacena la información persistente

Cada servicio corre de forma independiente dentro de contenedores Docker, lo que
garantiza portabilidad y consistencia del entorno. 

---

#   FLUJO DE UNA PETICIÓN HTTP

1. El cliente (Postman o navegador) envía una solicitud HTTP
2. Nginx recibe la solicitud y la redirige a Laravel 
3. Laravel procesa la ruta en `routes/api.php`
4. El Controller ejecuta la lógica de negocio
5. El Model interactúa con la base de datos MySQL mediante Eloquent ORM
6. Se retorna una respuesta en formato JSON 

--- 

#  BASE DE DATOS 

## TABLA: clients 

Campo           Tipo            Descripción
client_id       INT (PK)        Identificador único
first_name      VARCHAR(50)     Nombre
last_name       VARCHAR(50)     Apellido
email           VARCHAR(100)    Email único
phone_number    VARCHAR(20)     Teléfono
date_of_birth   DATE            Fecha de nacimiento
created_at      TIMESTAMP       Creación
updated_at      TIMESTAMP       Actualización

- Optimización de consultas: 
    El campo `email` está definido como único en la base de datos, lo que implica
    la creación de un índice automático. Esto permite mejorar el rendimiento en
    búsquedas y validaciones, especialmente cuando la cantidad de registros aumenta. 

--- 

#   SEGURIDAD Y BUENAS PRÁCTICAS

- Uso de Eloquent ORM en Laravel: 
    En lugar de trabajar con SQL manual, se utiliza Eloquent, lo que ayuda a reducir
    errores y también previene ataques como SQL Injection de forma automática. 

- Validación de datos en el backend: 
    Se implementó validación en los métodos `store` y `update` del controlador, asegurando
    que los datos cumplan con el formato esperado antes de ser guardados en la base de datos.

- Protección contra Mass Assignment: 
    En el modelo `Client` se utiliza la propiedad `$fillable`, lo que permite definir qué
    campos pueden ser asignados. Esto evita que se puedan inyectar datos no permitidos desde
    el request. 

- Manejo de errores:
    Se utilizan métodos como `firstOrFail()`, lo que permite devolver respuestas HTTP
    adecuadas (por ejemplo, 404 cuando un recurso no existe), mejorando el control de errores.

- Separación de responsabilidades bajo arquitectura MVC:
    - Model: acceso a datos
    - Controller: lógica de negocio
    - Routes: definición de endpoints

- Uso de Docker:
    Se utilizó Docker para separar los servicios (Nginx, Laravel, MySQL), lo que permite
    mantener un entorno consistente y fácil de ejecutar en cualquier máquina. 

--- 
#   CRITERIOS DE CALIDAD DEL SPRINT 0

## 1. Modularidad

El proyecto está organizado siguiendo MVC, lo que ayuda a tenerlo más ordenado.
Los Models manejan datos, los Controllers se encargan de la lógica y las Routes definen
endpoints.

---
## 2. Mantenibilidad

Al usar Laravel, la estructura ya viene bastante ordenada, lo que ayuda a que el proyecto sea
fácil de mantener o escalar después. 

---
## 3. Separación de responsabilidades

Cada parte del sistema cumple su función sin mezclarse: 

- Los controladores no interactúan directamente con SQL
- Los modelos se encargan de la base de datos
- Las rutas solo definen qué endpoint se está usando

---

## 4. Portabilidad

Debido a Docker, el proyecto puede ejecutarse en cualquier computador sin necesidad de
configuraciones manuales complejas. 
Solo se levanta el entorno y funciona de la misma forma en todos lados. 

--- 

## 5. Trazabilidad de errores

Laravel guarda automáticamente los errores en los logs del sistema, lo que permite revisar
qué pasó cuando algo falla y facilita mucho la depuración. 

---

## 6. Claridad de configuración

El archivo `.env` permite configurar variables como la base de datos sin tocar el código fuente. 
Así ayuda a que el proyecto sea más seguro, fácil y limpio de ajustar en distintos entornos.

---

#   EJECUCIÓN DEL PROYECTO

1. Clonar el repositorio (Descargar una copia del proyecto)

2. Levantar Docker 
    Asegurarse de que Docker esté ejecutándose antes de continuar. 

3. Ejecutar en el terminal, dentro del proyecto: 
    docker-compose up -d --build (levanta todos los servicios en segundo plano)

4. Ejecutar las migraciones de la base de datos:
    docker exec -it php_app php artisan migrate:fresh

5. Acceder al endpoint de prueba: 
    http://localhost:8000/api/health

--- 

#   ENDPOINTS DISPONIBLES 

##  HEALTH 

GET /api/health 

Respuesta: 

{ 
    "status": "online",
    "version": "1.0.0",
    "environment": "docker"
}

##  CLIENTS (CRUD)

- **Lista de clientes** 

GET /api/clients

---

- **Crear cliente**

POST /api/clients

Body: 

{
    "first_name": "Ana", 
    "last_name": "Lopez",
    "email": "ana@example.com",
    "phone_number": "555123456",
    "date_of_birth": "2000-01-01"
}

---

- **Actualizar cliente**

PUT /api/clients/{id}

--- 

- **Eliminar cliente**

DELETE /api/clients/{id}

--- 

#   PRUEBAS SOLICITADAS

Las pruebas se realizaron utilizando Postman, donde se verificó el correcto funcionamiento
de los endpoints principales de la API.

Se probaron los métodos GET, POST, PUT y DELETE, asegurando que cada uno respondiera 
correctamente según su función. 

También se comprobó que las respuestas fueran de formato JSON y con los códigos HTTP
correspondientes (200, 201 y 204 dependiendo de la operación).


Además, se validó que los datos se guardaran correctamente en la base de datos MySQL, 
consultando directamente la tabla `clients` para comprobar el flujo de la información.

(Se incluye una colección de Postman en formato JSON dentro del proyecto en la carpeta postman,
la cual contiene todas las solicitudes utilizadas para probar la API, facilitando
la validación y reutilización de los endpoints).

---

## EJEMPLOS DE RESPUESTAS REALES

GET http://localhost:8000/api/clients 

[
    {
        "client_id": 1,
        "first_name": "Ana",
        "last_name": "Lopez",
        "email": "ana@example.com",
        "phone_number": "555123456",
        "date_of_birth": "2000-01-01",
        "created_at": "2026-04-18T18:27:59.000000Z",
        "updated_at": "2026-04-18T18:27:59.000000Z"
    },
    {
        "client_id": 2,
        "first_name": "Pedro",
        "last_name": "Gonzalez",
        "email": "pedro@example.com",
        "phone_number": "555654321",
        "date_of_birth": "2002-02-03",
        "created_at": "2026-04-18T18:28:46.000000Z",
        "updated_at": "2026-04-18T18:29:46.000000Z"
    }
]

--- 

POST http://localhost:8000/api/clients

{
    "first_name": "Marcos",
    "last_name": "Martinez",
    "email": "marcos@example.com",
    "phone_number": "555987654",
    "date_of_birth": "2005-05-05",
    "updated_at": "2026-04-18T19:28:05.000000Z",
    "created_at": "2026-04-18T19:28:05.000000Z",
    "client_id": 6
}

---
PUT http://localhost:8000/api/clients/6

{
    "client_id": 6,
    "first_name": "Marcos",
    "last_name": "Martinez",
    "email": "marcos@example.com",
    "phone_number": "555987654",
    "date_of_birth": "2005-05-06",
    "created_at": "2026-04-18T19:28:05.000000Z",
    "updated_at": "2026-04-18T19:29:14.000000Z"
}

---

DELETE http://localhost:8000/api/clients/6

{
    "message": "Cliente eliminado correctamente"
}

---

#   DIAGRAMA DE ARQUITECTURA

Cliente (Postman / Navegador)
            ↓
          Nginx
            ↓
Laravel (MVC: Controller → Model)
            ↓
          MySQL

---

#  MEJORAS A FUTURO Y ESCALABILIDAD

Como mejora a futuro, el proyecto se podría escalar usando varios contenedores de la
aplicación (Laravel con PHP - FPM) junto a un balanceador de carga (load balancer), de 
forma que las solicitudes se repartan mejor y el sistema pueda soportar más usuarios 
sin caerse o volverse lento. 

También se podría agregar un sistema de caché en consultas que se repiten mucho, como por
ejemplo la lista de clientes, para mejorar el rendimiento y hacer las respuestas más
rápidas. 

Por otro lado, como mejora a nivel de código, se podría implementar el patrón Repository
para separar aún más la lógica de acceso a datos. Esto ayudaría a que el proyecto sea más
ordenado, más fácil de mantener y también facilitaría hacer pruebas en el futuro. 

---

#   CONCLUSIÓN

En general, este proyecto me ayudó a entender mejor cómo se conecta todo el backend con 
Docker, Laravel y la base de datos, y cómo cada parte cumple su rol dentro de la 
arquitectura sin mezclarse entre sí. 


---

# EVALUACIÓN N°2 - API REST con Docker y Laravel

--- 

#   INTRODUCCIÓN DEL PROYECTO 

Este proyecto consiste en la continuación del desarrollo de una API REST para la gestión
de clientes, implementada con Laravel y un entorno contenerizado usando Docker. 

En esta segunda evaluación, el sistema ya no solo funciona a nivel estructural, sino que
ahora permite gestionar información real persistida en base de datos, cumpliendo con un 
contrato de datos definido. 

El sistema permite:
- Verificar el estado del backend
- Crear, listar, actualizar y eliminar clientes (CRUD)
- Validar datos de entrada (como email único)
- Responder con códigos HTTP correctos

El objetivo principal es demostrar que la API funciona correctamente bajo un estándar RESTful, 
conectándose a una base de datos MySQL y entregando respuestas en formato JSON.

---

#   ESQUEMA FORMAL DE LA API

A continuación se muestran los endpoints principales de la API, indicando el método HTTP 
utilizado, la función de cada servicio y ejemplos de request y response esperados. 

---

## SERVICIO 1 - Verificar estado del sistema

Campo               Detalle
Método              GET
Endpoint            `/api/health`
Descripción         Verifica que el backend esté operativo. No requiere parámetros. 
Headers             `Accept: application/json`

**Request:**

**Response exitoso - 200 OK:**

JSON 

{
    "status": "online",
    "version": "1.0.0",
    "environment": "docker"
}

---

##  SERVICIO 2 - Listar todos los clientes

Campo               Detalle
Método              GET
Endpoint            `/api/v1/clientes`
Descripción         Retorna un arreglo JSON con todos los clientes registrados en la base de datos.
Headers             `Accept: application/json`

**Request:**

**Response exitoso - 200 OK:**

JSON

[
 {
    "id": 1,
    "rut": "11111111-1",
    "nombre": "Test",
    "apellido": "User",
    "email": "test1@example.com",
    "telefono": "123456789",
    "created_at": "2026-05-05T20:36:21.000000Z",
    "updated_at": "2026-05-05T20:36:21.000000Z"
 }
]

---

##  SERVICIO 3 - Obtener un cliente por ID

Campo               Detalle
Método              GET
Endpoint            `/api/v1/clientes/{id}`
Descripción         Retorna los datos de un cliente específico según su ID.
Headers             `Accept: application/json`
Parámetro           `{id}` - ID del cliente

**Request:**

**Response exitoso - 200 OK:**

JSON

{
    "id": 1,
    "rut": "11111111-1",
    "nombre": "Test",
    "apellido": "User",
    "email": "test1@example.com",
    "telefono": "123456789",
    "created_at": "2026-05-05T20:36:21.000000Z",
    "updated_at": "2026-05-05T20:36:21.000000Z"
}

## En caso de no encontrar el ID del cliente

**Response error - 404 Not Found:**

JSON

{
    "message": "No query results for model [App\\Models\\Cliente] 99"
}

--- 

##  SERVICIO 4 - Crear un nuevo cliente

Campo               Detalle
Método              POST
Endpoint            `/api/v1/clientes`
Descripción         Registra un nuevo cliente en la base de datos. Valida `rut` y `email`.
Headers             `Accept: application/json`, `Content-Type: application/json`

**Request body (JSON):**

JSON

{
    "rut": "55555555-5",
    "nombre": "Test2",
    "apellido": "User2",
    "email": "test2@example.com",
    "telefono": "9876543210"
}

Campo      Tipo       Requerido     Validaciones
rut        string     Si            Único en tabla clientes
nombre     string     Si            Máximo 100 caracteres
apellido   string     Si            Máximo 100 caracteres
email      string     Si            Formato email, único en tabla
telefono   string     No            Máximo 20 caracteres

**Response exitoso - 201 Created:**

JSON

{
    "rut": "55555555-5",
    "nombre": "Test2",
    "apellido": "User2",
    "email": "test2@example.com",
    "telefono": "9876543210",
    "created_at": "2026-05-05T22:56:08.000000Z",
    "updated_at": "2026-05-05T22:56:08.000000Z",
    "id": 4
}

## En caso de email o rut duplicado

**Response error - 422 Unprocessable Entity:**

JSON

{
    "message": "The email has already been taken.",
    "errors": {
        "email": [
            "The email has already been taken."
        ]
    }
}

---

## SERVICIO 5 - Actualizar un cliente

Campo               Detalle
Método              PUT
Endpoint            `/api/v1/clientes/{id}`
Descripción         Actualiza uno o más campos de un cliente existente.
Headers             `Accept: application/json`, `Content-Type: application/json`
Parámetro           `{id}` - ID del cliente

**Request body (JSON) - se deben enviar solo los campos que se actualizarán:**

JSON 

{
    "nombre": "Test2 - Actualización"
}

**Response exitoso - 200 OK:**

JSON

{
    "id": 4,
    "rut": "55555555-5",
    "nombre": "Test2 - Actualización",
    "apellido": "User2",
    "email": "test2@example.com",
    "telefono": "9876543210",
    "created_at": "2026-05-05T22:56:08.000000Z",
    "updated_at": "2026-05-05T23:01:42.000000Z"

}

## En caso de falla

**Response error - 404 Not Found:**

JSON

{
    "message": "No query results for model [App\\Models\\Cliente] 99"
}

---

## SERVICIO 6 - Eliminar un cliente

Campo               Detalle
Método              DELETE
Endpoint            `/api/v1/clientes/{id}`
Descripción         Elimina permanentemente un cliente de la base de datos.
Headers             `Accept: application/json`
Parámetro           `{id}` - ID del cliente

**Request:**

**Response exitoso - 200 OK:**

{
    "message": "Cliente eliminado correctamente"
}

## En caso de fallar

**Response error - 404 Not Found:**

JSON

{
    "message": "No query results for model [App\\Models\\Cliente] 99"
}

---

## RESUMEN DE ENDPOINTS

#  Método   Endpoint                  Descripción               Código Éxito
1  GET      `/api/health`             Estado del sistema        200
2  GET      `/api/v1/clientes`        Listar clientes           200
3  GET      `/api/v1/clientes/{id}`   Obtener cliente por ID    200
4  POST     `/api/v1/clientes`        Crear cliente             201
5  PUT      `/api/v1/clientes/{id}`   Actualizar cliente        200
6  DELETE   `/api/v1/clientes/{id}`   Eliminar cliente          200

---

#   TECNOLOGÍAS UTILIZADAS

- PHP 8.2 (Lenguaje backend)
- Laravel (Framework MVC)
- MySQL (Base de datos)
- Nginx (Servidor web)
- Docker / Docker Compose (Contenerización)
- Postman (Prueba de API)

--- 

#   ARQUITECTURA DEL SISTEMA (MVC + DOCKER)

El sistema está compuesto por 3 servicios principales:

- **Nginx:** Recibe las solicitudes HTTP del cliente
- **Laravel (PHP-FPM):** Procesa la lógica de negocio bajo arquitectura MVC
- **MySQL:** Almacena la información persistente

Cada servicio corre de forma independiente dentro de contenedores Docker, lo que
garantiza portabilidad y consistencia del entorno. 

---

#   FLUJO DE UNA PETICIÓN HTTP

1. El cliente (Postman o navegador) envía una solicitud HTTP
2. Nginx recibe la solicitud y la redirige a Laravel
3. Laravel procesa la ruta en `routes/api.php`
4. El Controller ejecuta la lógica de negocio
5. El Model interactúa con la base de datos MySQL mediante Eloquent ORM
6. Se retorna una respuesta en formato JSON 

--- 

#   BASE DE DATOS

## TABLA: clientes

Campo           Tipo            Descripción
id              INT (PK)        Identificador único
rut             VARCHAR         Rut único del cliente   
nombre          VARCHAR         Nombre
apellido        VARCHAR         Apellido
email           VARCHAR         Email único
telefono        VARCHAR         Teléfono
created_at      TIMESTAMP       Creación
updated_at      TIMESTAMP       Actualización

- Optimización de consultas:
    Los campos `email` y `rut` están definidos como únicos en la base de datos, 
    lo que mejora el rendimiento en búsquedas y evita duplicidad de datos. 

--- 

#   SEGURIDAD Y BUENAS PRÁCTICAS

- Uso de Eloquent ORM en Laravel:
    Permite evitar consultas SQL manuales y reduce errores, además de prevenir
    ataques como SQL Injection. 

- Validación de datos en el backend:
    Se valida que los datos cumplan con el formato esperado, incluyendo:
    - Email válido
    - Email único
    - Rut único

- Protección contra Mass Assignment: 
    Se utiliza `$fillable` en el modelo `Cliente`, asegurando que solo ciertos
    campos puedan ser asignados desde el request. 

- Manejo de errores: 
    Laravel devuelve respuestas HTTP adecuadas:
    - 200 OK
    - 201 Created
    - 422 Unprocessable Entity (validación)

- Separación de responsabilidades (MVC):
    - Model: acceso a datos
    - Controller: lógica de negocio
    - Routes: definición de endpoints

- Uso de Docker:
    Permite ejecutar el proyecto en cualquier entorno sin configuraciones complejas. 

--- 

#   EJECUCIÓN DEL PROYECTO

1. Clonar el repositorio
2. Levantar Docker
3. Ejecutar en el terminal, dentro del proyecto:
    docker-compose up -d --build

4. Ejecutar las migraciones de la base de datos:
    docker exec -it php_app php artisan migrate:fresh

5. Acceder al endpoint de prueba:
    http://localhost:8000/api/health

---

#   ENDPOINTS DISPONIBLES:

## HEALTH 

GET /api/health

{
    "status": "online",
    "version": "1.0.0",
    "environment": "docker"
}

--- 

## CLIENTES (API V1)

GET /api/v1/clientes
→ Lista todos los clientes

200 OK

[
    {
        "id": 2,
        "rut": "11111111-1",
        "nombre": "Test",
        "apellido": "User",
        "email": "test1@example.com",
        "telefono": "123456789",
        "created_at": "2026-05-05T20:36:21.000000Z",
        "updated_at": "2026-05-05T20:36:21.000000Z"
    },
    {
        "id": 3,
        "rut": "22222222-2",
        "nombre": "Error",
        "apellido": "Duplicado",
        "email": "fernanda@example.com",
        "telefono": "111111111",
        "created_at": "2026-05-05T20:50:28.000000Z",
        "updated_at": "2026-05-05T20:50:28.000000Z"
    }
]

--- 

POST /api/v1/clientes
→ Crear un cliente

201 Created

{
    "rut": "55555555-5",
    "nombre": "Test2",
    "apellido": "User2",
    "email": "test2@example.com",
    "telefono": "9876543210",
    "updated_at": "2026-05-05T22:56:08.000000Z",
    "created_at": "2026-05-05T22:56:08.000000Z",
    "id": 4
}

---

GET /api/v1/clientes/{id}
→ Obtiene un cliente por ID

200 OK

{
    "id": 2,
    "rut": "11111111-1",
    "nombre": "Test",
    "apellido": "User",
    "email": "test1@example.com",
    "telefono": "123456789",
    "created_at": "2026-05-05T20:36:21.000000Z",
    "updated_at": "2026-05-05T20:36:21.000000Z"
}

---

PUT /api/v1/clientes/{id}
→ Actualiza un cliente

200 OK

{
    "id": 4,
    "rut": "55555555-5",
    "nombre": "Test2 - Actualización",
    "apellido": "User2",
    "email": "test2@example.com",
    "telefono": "9876543210",
    "created_at": "2026-05-05T22:56:08.000000Z",
    "updated_at": "2026-05-05T23:01:42.000000Z"
}

---

DELETE /api/v1/clientes/{id}
→ Elimina un cliente

200 OK

{
    "message": "Cliente eliminado correctamente"
}

---

#   PRUEBAS SOLICITADAS

Las pruebas se realizaron utilizando Postman, donde se verificó el correcto 
funcionamiento de todos los endpoints de la API.

Se probaron:
- Métodos GET, POST, PUT y DELETE
- Validación de datos
- Respuestas en formato JSON
- Códigos HTTP correctos

También se validó que los datos se guardaran correctamente en la base de datos MySQL. 

Se incluyó un caso de error: 
- Email duplicado → devuelve **422 Unprocessable Entity**

(Se incluye una colección de Postman en formato JSON dentro del proyecto en la carpeta `/postman/`,
la cual contiene todas las solicitudes utilizadas para probar la API).

--- 

#   POSTMAN

Se incluye una colección de Postman en la carpeta: 
    
    /postman

La colección contiene:
- Todos los endpoints de la API
- Ejemplos de request y response
- Caso de error de validación

--- 

#     DIAGRAMA DE ARQUITECTURA

            Cliente 
      (Postman / Navegador)
               ↓
             Nginx
               ↓
            Laravel
      (Controller →  Model)
               ↓
               MySQL

---

#   MEJORAS A FUTURO Y ESCALABILIDAD

Como mejora a futuro, el proyecto se podría escalar utilizando múltiples instancias
del backend junto a un balanceador de carga, permitiendo soportar más usuarios. 

También se podría implementar caché para optimizar consultas frecuentes, como el listado
de clientes, mejorando el rendimiento. 

Además, se podría aplicar el patrón Repository para separar la lógica de acceso a datos, 
mejorando la mantenibilidad del código. 

---

# CONCLUSIÓN

La idea principal de esta segunda parte del proyecto fue implementar una API REST funcional 
conectada a base de datos, cumpliendo con las validaciones solicitadas, estructura RESTful 
y aplicando buenas prácticas de desarrollo backend. 

Esto permitió entender mejor cómo se gestiona la persistencia de datos, la validación y la
comunicación entre cliente y servidor dentro de una arquitectura real. 
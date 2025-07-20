## Cómo ejecutar el proyecto

1. Clona el repositorio  
  git clone https://github.com/aderaldoneto/challenge-laravel-2025.git  
  cd challenge-laravel-2025  

2. Configura el archivo env  
  cp .env.example .env  

3. Levanta los contenedores  
  docker-compose up -d --build  

4. Instala las dependencias  
  docker-compose exec app composer install  

5. Genera la clave de la aplicación  
  docker-compose exec app php artisan key:generate  

6. Ejecuta las migraciones y seeders  
  docker-compose exec app php artisan migrate:fresh --seed  

7. Ejecuta las pruebas  
  docker-compose exec app php artisan test  


# Seeders individuales  
php artisan db:seed SuperAdminSeeder  
php artisan db:seed CategorySeeder  
php artisan db:seed ProductSeeder  
php artisan db:seed MenuSeeder  


# Funcionalidades   
LIST  
GET http://localhost:8000/api/orders   
Retorna las órdenes cuyo estado es diferente a delivered  
Cacheado por 30 segundos via Redis  

CREATE NEW ORDER  
POST http://localhost:8000/api/orders   
Crea una orden con estado inicial initiated  
JSON:  
{
  "client_name": "Carlos Gómez",
	"client_phone": "+51 999 999 999",
  "client_address": "Av. Peru 123",
  "items": [
    { "description": "Lomo saltado", "quantity": 1, "unit_price": 60 },
    { "description": "Inka Kola", "quantity": 2, "unit_price": 10 }
  ]
}  

SEE DETAILS  
GET http://localhost:8000/api/orders/{id}   
Muestra todos los datos: cliente, ítems, total y estado actual  

NEXT STATUS  
POST http://localhost:8000/api/orders/{id}/advance   
Avanza estados: initiated > confirmed > sent > delivered  
Al llegar a delivered, la orden se elimina de la base de datos y del caché  


# ¿Cómo asegurarías que esta API escale ante alta concurrencia?  
Usaría caché para datos públicos como menús y categorías.  
Mejoraría la base de datos con índices y usando with() para evitar consultas innecesarias.  
Acciones lentas, las pondría en una cola asíncrona.  

# ¿Qué estrategia seguirías para desacoplar la lógica del dominio de Laravel/Eloquent?  
Usar servicios o acciones para sacar la lógica del controlador.  
 

# ¿Cómo manejarías versiones de la API en producción?  
Crearía rutas estandarizadas como /api/v1, /api/v2, /api/v3, etc., y organizaría los controladores en carpetas separadas.  
Mantendría activas las versiones antiguas por un tiempo para no romper nada.  

# ------------------------------------------------


# 🧪 OlaClick Backend Challenge - Laravel Edition

## 🎯 Objetivo

Construir una API RESTful para la gestión de órdenes de un restaurante, implementada en **Laravel**, siguiendo principios **SOLID**, usando **Eloquent ORM**, **PostgreSQL** como base de datos y **Redis** para caché. La solución debe estar **contenedorizada con Docker**.

---

## 📌 Requerimientos Funcionales

### 1. Listar órdenes
- Endpoint: `GET /api/orders`
- Retorna todas las órdenes activas (`status != 'delivered'`).
- Debe usar Redis para cachear el resultado (TTL: 30s).

### 2. Crear una nueva orden
- Endpoint: `POST /api/orders`
- Crea una nueva orden con estado inicial `initiated`.
- Estructura esperada:
  ```json
  {
    "client_name": "Carlos Gómez",
    "items": [
      { "description": "Lomo saltado", "quantity": 1, "unit_price": 60 },
      { "description": "Inka Kola", "quantity": 2, "unit_price": 10 }
    ]
  }

### 3. Avanzar estado de una orden
Endpoint: `POST /api/orders/{id}/advance`

Transición:

initiated → sent → delivered

Si llega a delivered, la orden debe ser eliminada de la base de datos y del caché.

### 4. Ver detalle de una orden
Endpoint: `GET /api/orders/{id}`

Muestra datos completos incluyendo items, totales y estado actual.

## 🧱 Consideraciones Técnicas
- Usar Laravel 10+
- Base de datos: PostgreSQL
- Cache: Redis
- Arquitectura REST
- Principios SOLID aplicados (ej. inyección de dependencias, separación de responsabilidades)
- Modelado con Eloquent ORM
- Validaciones robustas con Form Requests
- Tests unitarios o de feature (al menos 1 funcionalidad)
- Contenerización con Docker + Docker Compose

## 📦 Estructura sugerida
```
app/
├── Http/
│   ├── Controllers/
│   ├── Requests/
├── Models/
├── Services/
├── Repositories/
routes/
├── api.php
```

## 🧪 Extra Points
- Documentación en Swagger o Postman
- Seeders y factories para testeo rápido
- Logs de cambios de estado con timestamps

## 🚀 Cómo entregar
- Haz un fork de este repositorio o clónalo como plantilla.
- Implementa la solución.
- Incluye instrucciones claras en un README.md para levantar el proyecto con Docker.
- Comparte el repositorio (público o privado) con el equipo de OlaClick enviando un push.

## ❓ Preguntas opcionales para explicar
- ¿Cómo asegurarías que esta API escale ante alta concurrencia?
- ¿Qué estrategia seguirías para desacoplar la lógica del dominio de Laravel/Eloquent?
- ¿Cómo manejarías versiones de la API en producción?

**¡Mucho éxito!** 💡
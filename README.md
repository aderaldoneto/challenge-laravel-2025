## Como rodar o projeto

1. Clone o repositório 
  git clone https://github.com/aderaldoneto/challenge-laravel-2025.git
  cd challenge-laravel-2025

2. Configure o .env 
  cp .env.example .env

3. Suba os containers 
  docker-compose up -d --build

4. Instale as dependências 
  docker-compose exec app composer install

5. Chave da aplicação
  docker-compose exec app php artisan key:generate

6. Execute as migrations e seeders
  docker-compose exec app php artisan migrate:fresh --seed

7. Execute os testes
  docker-compose exec app php artisan test



# Criar registros no banco de dados
php artisan db:seed SuperAdminSeeder
php artisan db:seed CategorySeeder
php artisan db:seed ProductSeeder
php artisan db:seed MenuSeeder



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
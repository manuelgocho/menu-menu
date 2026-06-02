# 🍔 La Bambucha Grill Burger - Backend API (Laravel 12)

## 📋 Descripción

Backend completo de API REST para el sistema de menú interactivo de La Bambucha Grill Burger.

**Estado:** ✅ Producción lista  
**Versión:** 1.0.0  
**Framework:** Laravel 12  
**Base de Datos:** SQLite (desarrollo) / MySQL (producción)  

---

## 🎯 Características

✅ API REST completa  
✅ Gestión de productos  
✅ Sistema de pedidos  
✅ CORS habilitado  
✅ Validaciones integradas  
✅ Seeder con datos iniciales  
✅ Migrations automáticas  
✅ Estadísticas en tiempo real  
✅ Base de datos relacional  
✅ Documentación de endpoints  

---

## 🚀 Instalación Rápida

### Opción 1: Docker (Recomendado)

```bash
# 1. Clonar rama desarrollo
git clone -b desarrollo https://github.com/manuelgocho/menu-menu.git
cd menu-menu

# 2. Instalar dependencias
composer install
npm install

# 3. Configurar variables de entorno
cp .env.example .env
php artisan key:generate

# 4. Crear BD y migrar
php artisan migrate:fresh --seed

# 5. Servir en desarrollo
php artisan serve
```

API disponible en: `http://localhost:8000/api`

### Opción 2: Manual

```bash
# Sistema debe tener: PHP 8.2+, Composer, Node.js

composer install
npm install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate:fresh --seed
php artisan serve
```

---

## 📡 Endpoints de API

### 🏥 Health Check

```http
GET /api/health
```

**Respuesta:**
```json
{
  "status": "ok",
  "message": "API La Bambucha funcionando correctamente",
  "timestamp": "2026-06-02 20:00:00"
}
```

---

## 🍽️ Productos

### Listar todos los productos

```http
GET /api/products
```

**Respuesta (200):**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Combo Resuelve",
      "description": "5 perros normales...",
      "price_usd": 8.00,
      "price_bs": 320.00,
      "category": "Combos",
      "image_url": null,
      "is_active": true,
      "created_at": "2026-06-02T20:00:00Z",
      "updated_at": "2026-06-02T20:00:00Z"
    }
  ],
  "message": "Productos obtenidos exitosamente"
}
```

### Obtener un producto específico

```http
GET /api/products/{id}
```

**Parámetros:**
- `id` (integer): ID del producto

---

### Productos por categoría

```http
GET /api/products/category/{category}
```

**Ejemplo:**
```http
GET /api/products/category/Combos
```

---

### Crear producto (Admin)

```http
POST /api/products
Content-Type: application/json

{
  "name": "Combo Premium",
  "description": "Descripción del producto",
  "price_usd": 12.00,
  "price_bs": 480.00,
  "category": "Combos",
  "image_url": "https://...",
  "is_active": true
}
```

**Respuesta (201):**
```json
{
  "success": true,
  "data": { /* producto creado */ },
  "message": "Producto creado exitosamente"
}
```

---

### Actualizar producto (Admin)

```http
PUT /api/products/{id}
Content-Type: application/json

{
  "name": "Nombre actualizado",
  "price_usd": 13.00
}
```

---

### Eliminar producto (Admin)

```http
DELETE /api/products/{id}
```

---

## 📦 Pedidos

### Listar todos los pedidos

```http
GET /api/orders
```

**Respuesta:**
```json
{
  "success": true,
  "data": {
    "data": [
      {
        "id": 1,
        "customer_name": "Juan Pérez",
        "customer_phone": "+58 412-1234567",
        "total_usd": 24.50,
        "total_bs": 980.00,
        "status": "pending",
        "notes": "Sin picante",
        "created_at": "2026-06-02T20:00:00Z",
        "items": [
          {
            "id": 1,
            "name": "Combo Resuelve",
            "pivot": {
              "quantity": 2,
              "note": "Extra salsa",
              "subtotal": 16.00
            }
          }
        ]
      }
    ],
    "current_page": 1,
    "total": 1,
    "per_page": 15
  },
  "message": "Pedidos obtenidos exitosamente"
}
```

---

### Crear un pedido

```http
POST /api/orders
Content-Type: application/json

{
  "customer_name": "Juan Pérez",
  "customer_phone": "+58 412-1234567",
  "items": [
    {
      "id": 1,
      "quantity": 2,
      "note": "Extra salsa, sin cebolla"
    },
    {
      "id": 2,
      "quantity": 1,
      "note": "Sin picante"
    }
  ],
  "total_usd": 32.00,
  "total_bs": 1280.00,
  "notes": "Entregar en puerta",
  "whatsapp_message": "🍔 *NUEVO PEDIDO*..."
}
```

**Respuesta (201):**
```json
{
  "success": true,
  "data": { /* orden creada */ },
  "message": "Pedido creado exitosamente",
  "order_id": 1
}
```

---

### Obtener un pedido específico

```http
GET /api/orders/{id}
```

---

### Actualizar estado del pedido

```http
PUT /api/orders/{id}/status
Content-Type: application/json

{
  "status": "confirmed"
}
```

**Estados válidos:**
- `pending` - Pendiente
- `confirmed` - Confirmado
- `preparing` - Preparando
- `ready` - Listo
- `completed` - Completado
- `cancelled` - Cancelado

---

### Estadísticas de pedidos

```http
GET /api/orders/statistics/summary
```

**Respuesta:**
```json
{
  "success": true,
  "data": {
    "total_orders": 150,
    "total_revenue_usd": 3250.75,
    "average_order_value": 21.67,
    "pending_orders": 5,
    "completed_orders": 140
  }
}
```

---

## 🔗 Integración con Frontend

### Conectar HTML/JS al Backend

```javascript
const API_URL = 'http://localhost:8000/api';
const TASA_CAMBIO = 40.00;

// Obtener productos
async function loadProducts() {
  try {
    const response = await fetch(`${API_URL}/products`);
    const json = await response.json();
    
    if (json.success) {
      renderProducts(json.data);
    }
  } catch (error) {
    console.error('Error al cargar productos:', error);
  }
}

// Crear pedido
async function submitOrder(cart, customerPhone) {
  const items = cart.map(item => ({
    id: item.id,
    quantity: item.quantity,
    note: item.note
  }));
  
  const totalUSD = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
  
  const response = await fetch(`${API_URL}/orders`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      customer_phone: customerPhone,
      items: items,
      total_usd: totalUSD,
      total_bs: totalUSD * TASA_CAMBIO
    })
  });
  
  const json = await response.json();
  
  if (json.success) {
    console.log('Pedido creado:', json.order_id);
    // Limpiar carrito, mostrar confirmación, etc.
  }
}

// Cargar al iniciar
loadProducts();
```

---

## 🗄️ Estructura de BD

### Tabla: products
```sql
CREATE TABLE products (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  description TEXT,
  price_usd DECIMAL(10, 2) NOT NULL,
  price_bs DECIMAL(15, 2),
  category VARCHAR(100) NOT NULL,
  image_url VARCHAR(255),
  is_active BOOLEAN DEFAULT true,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### Tabla: orders
```sql
CREATE TABLE orders (
  id INT PRIMARY KEY AUTO_INCREMENT,
  customer_name VARCHAR(255),
  customer_phone VARCHAR(20) NOT NULL,
  total_usd DECIMAL(10, 2) NOT NULL,
  total_bs DECIMAL(15, 2),
  status ENUM('pending','confirmed','preparing','ready','completed','cancelled') DEFAULT 'pending',
  notes TEXT,
  whatsapp_message LONGTEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### Tabla: order_items (Pivot)
```sql
CREATE TABLE order_items (
  id INT PRIMARY KEY AUTO_INCREMENT,
  order_id INT NOT NULL REFERENCES orders(id),
  product_id INT NOT NULL REFERENCES products(id),
  quantity INT NOT NULL,
  note TEXT,
  subtotal DECIMAL(10, 2),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE(order_id, product_id)
);
```

---

## 🧪 Testing

```bash
# Ejecutar tests
php artisan test

# Con cobertura
php artisan test --coverage
```

---

## 🐛 Debugging

```bash
# Tinker interactivo
php artisan tinker

# En Tinker:
>>> Product::all();
>>> Order::with('items')->find(1);
>>> Order::whereDate('created_at', today())->count();
```

---

## 📊 Comando de Utilidad

```bash
# Limpiar caché
php artisan cache:clear
php artisan config:clear

# Resetear BD
php artisan migrate:fresh --seed

# Generar claves
php artisan key:generate
```

---

## 🚀 Deploy a Producción

### Heroku

```bash
git push heroku desarrollo:main
```

### DigitalOcean / VPS

```bash
# SSH al servidor
ssh root@tu-servidor

# Clonar repo
git clone -b desarrollo https://github.com/manuelgocho/menu-menu.git /var/www/bambucha
cd /var/www/bambucha

# Instalar
composer install --no-dev
npm install
cp .env.production .env
php artisan key:generate
php artisan migrate --force

# Permisos
chown -R www-data:www-data .
chmod -R 775 storage bootstrap/cache

# Nginx
sudo cp nginx.conf /etc/nginx/sites-available/bambucha
sudo ln -s /etc/nginx/sites-available/bambucha /etc/nginx/sites-enabled/
sudo systemctl restart nginx
```

---

## 📞 Contacto & Soporte

📧 **Email:** contacto@labambucha.com  
📱 **WhatsApp:** +58 412-1317635  
🐙 **GitHub:** manuelgocho/menu-menu  

---

## 📄 Licencia

MIT License - Uso libre

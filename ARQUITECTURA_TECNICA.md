# 📋 Arquitectura Técnica - La Bambucha Grill Burger

## Documentación Detallada de la Solución

**Versión:** 1.0  
**Fecha:** Junio 2026  
**Autor:** Manual - La Bambucha Grill Burger  
**Estado:** Producción

---

## 📑 Tabla de Contenidos

1. [Visión General](#visión-general)
2. [Stack Tecnológico](#stack-tecnológico)
3. [Arquitectura de Componentes](#arquitectura-de-componentes)
4. [Sistema de Carrito](#sistema-de-carrito)
5. [Diseño Responsivo](#diseño-responsivo)
6. [Integración WhatsApp](#integración-whatsapp)
7. [Flujo de Datos](#flujo-de-datos)
8. [Errores Resueltos](#errores-resueltos)
9. [Guía de Escalabilidad](#guía-de-escalabilidad)
10. [Mantenimiento y Mejoras](#mantenimiento-y-mejoras)

---

## 🎯 Visión General

**La Bambucha Grill Burger** es una aplicación web de menú interactivo diseñada para:

- Mostrar catálogo de productos (Combos, Hamburguesas, Bebidas)
- Gestionar carrito de compra con conversión de divisas (USD ↔ Bs)
- Procesar pedidos directamente vía WhatsApp
- Optimización para móviles y desktop
- Experiencia de usuario fluida sin retrasos

### Objetivos Técnicos

✅ Interfaz responsiva y moderna  
✅ Sistema de carrito sin backend (Client-side)  
✅ Conversión de divisas en tiempo real  
✅ Integración directa con WhatsApp Business  
✅ Rendimiento optimizado (< 2s load time)  
✅ Validación de entrada en cliente  

---

## 💻 Stack Tecnológico

### Frontend

| Tecnología | Versión | Propósito |
|-----------|---------|----------|
| **HTML5** | - | Estructura semántica |
| **Tailwind CSS** | via CDN | Framework CSS utilitario |
| **JavaScript Vanilla** | ES6+ | Lógica interactiva (sin jQuery/Framework) |
| **Google Fonts** | Inter | Tipografía personalizada |

### Herramientas de Desarrollo

```json
{
  "cdn": {
    "tailwind": "https://cdn.tailwindcss.com",
    "fonts": "https://fonts.googleapis.com/css2?family=Inter"
  },
  "deployment": "GitHub Pages / Vercel (Sugerido)",
  "version_control": "Git + GitHub"
}
```

### Sin Dependencias de Backend

- ❌ No Node.js requerido
- ❌ No Base de datos
- ❌ No API REST interna
- ✅ Totalmente estático + lógica JavaScript

---

## 🏗️ Arquitectura de Componentes

### Estructura HTML Jerárquica

```
<html>
├── <head>
│   ├── Meta tags (Viewport, Charset)
│   ├── Tailwind CSS (CDN)
│   ├── Google Fonts
│   └── Estilos personalizados
├── <body>
│   ├── <header> (Navegación Sticky)
│   │   ├── Logo + Nombre
│   │   ├── Botón Carrito (con badge de cantidad)
│   │   └── Navegación (Inicio, Menú, WhatsApp, Instagram)
│   ├── <section id="inicio"> (Hero Section)
│   │   ├── Propuesta de valor
│   │   ├── CTA buttons
│   │   └── Imagen decorativa
│   ├── <section id="menu"> (Catálogo)
│   │   ├── Filtros (Todos, Combos, Hamburguesas)
│   │   └── Grid de productos
│   ├── <footer> (Contacto)
│   ├── <div id="cart-drawer"> (Modal Carrito)
│   │   ├── Lista de items
│   │   ├── Cálculos totales
│   │   └── Botón WhatsApp
│   └── <script> (Lógica JavaScript)
```

### 1. Componente Header (Encabezado)

**Responsabilidades:**
- Branding consistente
- Navegación principal
- Acceso rápido al carrito

**Clases Tailwind Clave:**
```css
.sticky .top-0 .z-40         /* Fijo en top, sobre otros elementos */
.bg-gradient-to-r             /* Gradiente horizontal */
.shadow-[0_10px_28px...]     /* Sombra personalizada */
```

**Características:**
- Responsive: Logo adapta tamaño en sm/md
- Badge dinámico de cantidad de items
- Efecto hover en botones

---

### 2. Componente Hero (Sección de Inicio)

**Propósito:**
- Primera impresión visual
- Proposición de valor
- Llamadas a acción (CTA)

**Elementos:**
```html
<!-- Badge de destacado -->
<div class="inline-flex items-center gap-2 rounded-full ...">
  La mejor manera de comer carne
</div>

<!-- Titular principal con drop shadow -->
<h1 class="text-9xl font-black drop-shadow-[...]">
  La Bambucha
</h1>

<!-- Botones CTA con gradientes -->
<a href="#menu" class="bg-gradient-to-r from-red-700 to-yellow-400">
  Ver menú
</a>
```

**Diseño:**
- Grid de 2 columnas en desktop (md:)
- Centrado en móvil
- Radial gradients decorativos en fondo

---

### 3. Componente Menú (Catálogo)

**Estructura:**

```html
<!-- Filtros (Futura expansión) -->
<div class="flex gap-3 overflow-x-auto no-scrollbar">
  <button>Todos</button>
  <button>Combos</button>
  <button>Hamburguesas</button>
</div>

<!-- Grid de productos -->
<div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
  <!-- Tarjeta de producto -->
  <article class="rounded-[1.8rem] border overflow-hidden">
    <div class="relative h-64"> <!-- Imagen -->
    <div class="p-5"> <!-- Contenido -->
  </article>
</div>
```

**Tarjeta de Producto (Product Card):**

| Sección | Contenido | Función |
|---------|-----------|---------|
| **Imagen** | Placeholder / Foto del producto | Visual principal |
| **Badge** | Categoría (Combos, Hamburguesas) | Filtrado visual |
| **Nombre** | Nombre del producto | Identificación |
| **Precio** | USD / Bs | Información crítica |
| **Descripción** | Ingredientes/Especificación | Detalles |
| **Botón** | Agregar al carrito | CTA principal |

**Clases Tailwind Especiales:**
```css
.group.hover:-translate-y-1    /* Efecto elevación al hover */
.rounded-[1.8rem]              /* Border radius personalizado */
.bg-[#4a1f00]/92              /* Opacidad customizada */
.drop-shadow-[...]             /* Drop shadow personalizado */
```

---

### 4. Componente Carrito (Cart Drawer)

**Estructura del Modal:**

```
┌─────────────────────────────────────┐
│ Header (Título + Cerrar)            │  ← Sticky
├─────────────────────────────────────┤
│                                     │
│ Scroll Area (Items del carrito)     │  ← Flex-1 / Overflow
│                                     │
├─────────────────────────────────────┤
│ Total USD                           │  ← Sticky
│ Total Bs (Equivalente)              │
│ Botón WhatsApp                      │
└─────────────────────────────────────┘
```

**Problema Resuelto (Bug de Pointer Events):**

```javascript
// ❌ ANTES (Bloqueaba clics):
#cart-drawer.opacity-0 {
  pointer-events: none;  /* Se quedaba activo */
}

// ✅ DESPUÉS (Limpio):
#cart-drawer {
  pointer-events: none;  /* Por defecto deshabilitado */
  transition-all duration-300;
}

#cart-drawer.pointer-events-auto {  /* Solo cuando activo */
  pointer-events: auto;
}

#cart-container {
  transform: translateX(100%);  /* Fuera de pantalla */
  transition-transform duration-300;
}

#cart-container.translate-x-0 {
  transform: translateX(0);  /* Dentro de pantalla */
}
```

**Lógica de Toggle:**

```javascript
function toggleCart() {
  const drawer = document.getElementById('cart-drawer');
  const container = document.getElementById('cart-container');
  
  // Toggle bidireccional
  if(drawer.classList.contains('opacity-0')) {
    // Abrir
    drawer.classList.remove('opacity-0', 'pointer-events-none');
    container.classList.remove('translate-x-full');
  } else {
    // Cerrar
    drawer.classList.add('opacity-0', 'pointer-events-none');
    container.classList.add('translate-x-full');
  }
}
```

---

## 🛒 Sistema de Carrito

### Estructura de Datos

```javascript
// Modelo de item en carrito
{
  id: 1,                    // ID único del producto
  name: "Combo Resuelve",   // Nombre descriptivo
  price: 8.00,              // Precio en USD
  quantity: 2               // Cantidad seleccionada
}

// Array global
let cart = [];
```

### Operaciones CRUD

#### CREATE: Agregar Item

```javascript
function addToCart(id, name, price) {
  const existingItem = cart.find(item => item.id === id);
  
  if(existingItem) {
    // Si existe: incrementar cantidad
    existingItem.quantity += 1;
  } else {
    // Si no existe: crear nuevo item
    cart.push({ id, name, price, quantity: 1 });
  }
  
  updateCartUI();  // Renderizar cambios
}
```

**Invocación (HTML):**
```html
<button onclick="addToCart(1, 'Combo Resuelve', 8.00)">
  Agregar al carrito
</button>
```

#### READ: Obtener Items

```javascript
// Obtener item específico
const item = cart.find(item => item.id === id);

// Total de items
const totalItems = cart.reduce((acc, item) => acc + item.quantity, 0);

// Total en USD
let totalUSD = 0;
cart.forEach(item => {
  totalUSD += item.price * item.quantity;
});
```

#### UPDATE: Modificar Cantidad

```javascript
function changeQuantity(id, delta) {
  const item = cart.find(item => item.id === id);
  if(!item) return;

  item.quantity += delta;  // +1 o -1
  
  // Eliminar si cantidad <= 0
  if(item.quantity <= 0) {
    cart = cart.filter(item => item.id !== id);
  }
  
  updateCartUI();
}
```

#### DELETE: Remover Item

```javascript
function removeItem(id) {
  cart = cart.filter(item => item.id !== id);
  updateCartUI();
}
```

### Renderización de UI

```javascript
function updateCartUI() {
  const itemsContainer = document.getElementById('cart-items');
  const badge = document.getElementById('cart-badge');
  
  // 1️⃣ Actualizar badge de cantidad
  const totalItems = cart.reduce((acc, item) => acc + item.quantity, 0);
  if(totalItems > 0) {
    badge.innerText = totalItems;
    badge.classList.remove('hidden');
    badge.classList.add('flex');
  } else {
    badge.classList.add('hidden');
  }

  // 2️⃣ Limpiar renderización anterior
  itemsContainer.innerHTML = '';

  // 3️⃣ Si carrito vacío
  if(cart.length === 0) {
    itemsContainer.innerHTML = `
      <div class="h-full flex flex-col items-center justify-center">
        <p class="text-lg font-bold">Tu carrito está vacío</p>
      </div>`;
    document.getElementById('total-usd').innerText = "$0.00";
    document.getElementById('total-bs').innerText = "Bs 0,00";
    return;
  }

  // 4️⃣ Renderizar cada fila
  let totalUSD = 0;
  cart.forEach(item => {
    const subtotalUSD = item.price * item.quantity;
    totalUSD += subtotalUSD;
    const subtotalBs = subtotalUSD * TASA_CAMBIO;

    const row = document.createElement('div');
    row.className = "flex items-center justify-between gap-3 bg-white/5 p-4 rounded-2xl";
    row.innerHTML = `
      <div class="flex-1 min-w-0">
        <h4 class="font-black text-sm uppercase truncate text-yellow-100">
          ${item.name}
        </h4>
        <p class="text-xs text-gray-400 mt-0.5">
          $${item.price.toFixed(2)} c/u
        </p>
        <p class="text-xs text-yellow-400/80 font-bold mt-1">
          Subtotal: $${subtotalUSD.toFixed(2)} (Bs ${subtotalBs.toFixed(2)})
        </p>
      </div>
      <div class="flex items-center gap-2 bg-black/40 rounded-xl p-1">
        <button onclick="changeQuantity(${item.id}, -1)" class="w-8 h-8 ...">-</button>
        <span class="w-6 text-center font-black text-sm">${item.quantity}</span>
        <button onclick="changeQuantity(${item.id}, 1)" class="w-8 h-8 ...">+</button>
      </div>
      <button onclick="removeItem(${item.id})" class="text-red-400 ...">✕</button>
    `;
    itemsContainer.appendChild(row);
  });

  // 5️⃣ Actualizar totales
  const totalBs = totalUSD * TASA_CAMBIO;
  document.getElementById('total-usd').innerText = `$${totalUSD.toFixed(2)}`;
  document.getElementById('total-bs').innerText = 
    `Bs ${totalBs.toLocaleString('es-VE', { 
      minimumFractionDigits: 2, 
      maximumFractionDigits: 2 
    })}`;
}
```

---

## 💱 Sistema de Conversión de Divisas

### Configuración

```javascript
// Tasa de cambio referencial (MODIFICABLE)
const TASA_CAMBIO = 40.00;  // 1 USD = 40 Bs (ejemplo)

// En producción, considerar:
// - API de tasas reales (exchangerate-api.com)
// - Actualización cada hora
// - Validación de rango
```

### Cálculos

```javascript
// Conversión USD → Bs
const priceInBs = priceInUSD * TASA_CAMBIO;

// Formateo con locale venezolano
const formattedBs = priceInBs.toLocaleString('es-VE', {
  minimumFractionDigits: 2,
  maximumFractionDigits: 2
});
// Resultado: "Bs 320,00" (coma como separador decimal)
```

### Ubicación en UI

| Ubicación | Uso |
|-----------|-----|
| **Card de producto** | Ambos precios (USD + Bs) |
| **Carrito (item)** | Subtotal en ambas divisas |
| **Carrito (total)** | Totales generales |
| **WhatsApp message** | Resumen con ambas divisas |

---

## 📱 Diseño Responsivo

### Breakpoints Tailwind Utilizados

```css
/* Mobile first (por defecto) */
base

/* Small devices (640px) */
sm:

/* Medium devices (768px) */
md:

/* Large devices (1024px) */
lg:
```

### Ejemplos de Adaptabilidad

```html
<!-- Logo responsivo -->
<div class="h-[58px] w-[58px] sm:h-16 sm:w-16">
  <!-- 58px en mobile, 64px (16rem) en sm+ -->
</div>

<!-- Tipografía responsiva -->
<h1 class="text-6xl sm:text-7xl md:text-8xl lg:text-9xl">
  <!-- 6xl en mobile, 9xl en lg+ -->
</h1>

<!-- Grid responsivo -->
<div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
  <!-- 1 columna en mobile, 2 en sm, 3 en lg -->
</div>

<!-- Espaciado responsivo -->
<div class="px-4 sm:px-6 lg:px-8">
  <!-- 1rem en mobile, 1.5rem en sm, 2rem en lg -->
</div>
```

### Viewport Meta Tag

```html
<meta name="viewport" content="width=device-width, initial-scale=1.0">
```

Esto asegura que:
- ✅ El ancho se adapta al dispositivo
- ✅ No hay zoom inicial forzado
- ✅ Touch funciona correctamente

---

## 📲 Integración WhatsApp

### Flujo de Envío

```
┌──────────────────────────────────────────────────────┐
│ 1. Usuario hace clic en "Confirmar Pedido por WA"   │
└──────────────────────────────────────────────────────┘
                      ↓
┌──────────────────────────────────────────────────────┐
│ 2. Función sendOrderWhatsApp() se ejecuta            │
└──────────────────────────────────────────────────────┘
                      ↓
┌──────────────────────────────────────────────────────┐
│ 3. Construir mensaje formateado (Markdown)           │
│    - Listado de items con cantidades                 │
│    - Precios individuales y totales                  │
│    - Conversión USD ↔ Bs                             │
└──────────────────────────────────────────────────────┘
                      ↓
┌──────────────────────────────────────────────────────┐
│ 4. Codificar mensaje para URL (encodeURIComponent)  │
└──────────────────────────────────────────────────────┘
                      ↓
┌──────────────────────────────────────────────────────┐
│ 5. Generar URL de WhatsApp: wa.me/{numero}?text=... │
└──────────────────────────────────────────────────────┘
                      ↓
┌──────────────────────────────────────────────────────┐
│ 6. Abrir ventana nueva (window.open)                 │
└──────────────────────────────────────────────────────┘
                      ↓
┌──────────────────────────────────────────────────────┐
│ 7. Usuario llega a WhatsApp con mensaje pre-llenado │
└──────────────────────────────────────────────────────┘
```

### Código

```javascript
function sendOrderWhatsApp() {
  // Validación
  if(cart.length === 0) {
    alert("Agrega al menos un producto para generar tu pedido.");
    return;
  }

  // Construcción del mensaje
  let totalUSD = 0;
  let message = "🍔 *NUEVO PEDIDO - LA BAMBUCHA* 🍔\n\n";
  message += "Hola, me gustaría ordenar lo siguiente:\n\n";

  // Listar cada item
  cart.forEach(item => {
    const subtotalUSD = item.price * item.quantity;
    totalUSD += subtotalUSD;
    message += `• *${item.quantity}x* ${item.name} ($${item.price.toFixed(2)} c/u) -> *$${subtotalUSD.toFixed(2)}*\n`;
  });

  // Totales
  const totalBs = totalUSD * TASA_CAMBIO;
  message += `\n-------------------------\n`;
  message += `💵 *TOTAL USD:* $${totalUSD.toFixed(2)}\n`;
  message += `🇻🇪 *TOTAL BS (Ref):* Bs ${totalBs.toLocaleString('es-VE', { minimumFractionDigits: 2 })}\n\n`;
  message += "¡Quedo atento para coordinar el pago y el despacho! 👍";

  // Codificación URL
  const encodedMessage = encodeURIComponent(message);
  const phoneNumber = "584121317635";  // Número del negocio
  
  // Abrir WhatsApp
  window.open(`https://wa.me/${phoneNumber}?text=${encodedMessage}`, '_blank');
}
```

### Ejemplo de Mensaje Generado

```
🍔 *NUEVO PEDIDO - LA BAMBUCHA* 🍔

Hola, me gustaría ordenar lo siguiente:

• *2x* Combo Resuelve ($8.00 c/u) -> *$16.00*
• *1x* Súper Burger ($6.50 c/u) -> *$6.50*

-------------------------
💵 *TOTAL USD:* $22.50
🇻🇪 *TOTAL BS (Ref):* Bs 900,00

¡Quedo atento para coordinar el pago y el despacho! 👍
```

---

## 🔄 Flujo de Datos

### Diagrama de Estado

```
┌─────────────────────────────────────────────────────────┐
│                    PÁGINA CARGADA                       │
│            cart = [] (Array vacío)                       │
│         updateCartUI() invocado inicialmente             │
└─────────────────────────────────────────────────────────┘
                          ↓
                    Usuario navega
                          ↓
       ┌──────────────────┴──────────────────┐
       ↓                                      ↓
  VE PRODUCTO                          ABRE CARRITO
       ↓                                      ↓
  Hace clic en                         Visualiza items
  "Agregar"                            + Totales
       ↓                                      ↓
  addToCart(id, name, price)          Usuario puede:
       ↓                              - Cambiar cantidad
  Busca si existe en cart              - Remover items
       ↓                              - Cerrar modal
  ┌─────┴─────┐
  ↓           ↓
SI            NO
  ↓           ↓
INC ++     PUSH new
  ↓           ↓
  └─────┬─────┘
        ↓
   updateCartUI()
        ↓
  RE-RENDERIZAR TODO
        ↓
   Mostrar cambios
        ↓
  Usuario confirma pedido
        ↓
  sendOrderWhatsApp()
        ↓
  Construir mensaje
        ↓
  Abrir WhatsApp
        ↓
  PEDIDO ENVIADO ✅
```

### Eventos del Usuario (Event Listeners)

```javascript
/* Implícitos (inline onclick) */

// 1. Agregar producto
<button onclick="addToCart(id, name, price)">

// 2. Abrir/Cerrar carrito
<button onclick="toggleCart()">

// 3. Cambiar cantidad
<button onclick="changeQuantity(id, -1)">  // Restar
<button onclick="changeQuantity(id, +1)">  // Sumar

// 4. Eliminar item
<button onclick="removeItem(id)">

// 5. Enviar a WhatsApp
<button onclick="sendOrderWhatsApp()">
```

---

## 🐛 Errores Resueltos

### Error 1: Modal Bloquea Clics (Pointer Events)

**Síntoma:**
- Botones no responden después de abrir/cerrar carrito
- Click events propagados al modal

**Causa Raíz:**
```css
/* Problema */
#cart-drawer.opacity-0 {
  pointer-events: none;  /* Se aplicaba solo en estado visible */
}
/* Resultado: El div seguía bloqueando clics aunque fuese invisible */
```

**Solución Implementada:**
```css
/* Corrección */
#cart-drawer {
  pointer-events: none;  /* POR DEFECTO deshabilitado */
  transition-all duration-300;
}

.pointer-events-auto {
  pointer-events: auto;  /* Solo cuando está activo */
}
```

**JavaScript Actualizado:**
```javascript
function toggleCart() {
  const drawer = document.getElementById('cart-drawer');
  const container = document.getElementById('cart-container');
  
  if(drawer.classList.contains('opacity-0')) {
    drawer.classList.remove('opacity-0', 'pointer-events-none');
    container.classList.remove('translate-x-full');
  } else {
    drawer.classList.add('opacity-0', 'pointer-events-none');
    container.classList.add('translate-x-full');
  }
}
```

### Error 2: Scroll Bar en Elementos con Scroll

**Síntoma:**
- Barra de scroll visible en contenedores sin contenido suficiente

**Solución:**
```html
<!-- Aplicar clase global -->
<div class="no-scrollbar overflow-x-auto">
  <!-- Contenido -->
</div>
```

```css
/* CSS personalizado */
.no-scrollbar::-webkit-scrollbar {
  display: none;  /* Chrome/Safari */
}

.no-scrollbar {
  -ms-overflow-style: none;  /* Internet Explorer */
  scrollbar-width: none;     /* Firefox */
}
```

### Error 3: Formato de Divisas Inconsistente

**Síntoma:**
- Números con puntos en lugar de comas (formato US)
- No respeta formato venezolano

**Solución:**
```javascript
// Usar toLocaleString con locale específico
const formatted = totalBs.toLocaleString('es-VE', {
  minimumFractionDigits: 2,
  maximumFractionDigits: 2
});

// Resultado:
// 320.50 → "Bs 320,50" ✅ (coma como decimal)
// 1000.00 → "Bs 1.000,00" ✅ (punto como separador de miles)
```

---

## 📈 Guía de Escalabilidad

### Fase 1: Estado Actual (MVP)
- ✅ 2 productos hardcodeados
- ✅ Carrito en JavaScript puro
- ✅ Sin persistencia

### Fase 2: Próximas Mejoras (Corto Plazo)

#### 2.1 Base de Datos de Productos
```javascript
// De hardcoded a JSON
const products = [
  {
    id: 1,
    name: "Combo Resuelve",
    category: "combos",
    price: 8.00,
    description: "5 perros normales...",
    image: "combo-resuelve.jpg",
    available: true
  },
  // Más productos...
];

// Renderizar dinámicamente
function renderProducts(productsList) {
  productsList.forEach(product => {
    // Crear HTML para cada producto
    // Agregar al DOM
  });
}
```

#### 2.2 Sistema de Filtros Funcional
```javascript
// Filtrar por categoría
function filterByCategory(category) {
  if(category === 'todos') {
    return products;
  }
  return products.filter(p => p.category === category);
}

// Evento click en botones
document.querySelectorAll('[data-category]').forEach(btn => {
  btn.addEventListener('click', (e) => {
    const category = e.target.dataset.category;
    const filtered = filterByCategory(category);
    renderProducts(filtered);
  });
});
```

#### 2.3 Persistencia Local (LocalStorage)
```javascript
// Guardar carrito
function saveCart() {
  localStorage.setItem('bambuchaCart', JSON.stringify(cart));
}

// Cargar carrito al iniciar
function loadCart() {
  const saved = localStorage.getItem('bambuchaCart');
  if(saved) {
    cart = JSON.parse(saved);
    updateCartUI();
  }
}

// Ejecutar en carga de página
window.addEventListener('load', loadCart);

// Guardar cada cambio
function addToCart(id, name, price) {
  // ... lógica existente ...
  saveCart();
}
```

### Fase 3: Backend API (Mediano Plazo)

#### 3.1 Arquitectura Recomendada
```
Frontend (HTML + Tailwind + JS)
              ↓ (Fetch API)
      Backend Node.js/Express
              ↓
      PostgreSQL Database
```

#### 3.2 Endpoints Sugeridos
```
GET    /api/products              // Listar todos
GET    /api/products/:id          // Detalle
GET    /api/categories            // Categorías
POST   /api/orders                // Crear pedido
GET    /api/orders/:id            // Estado
POST   /api/orders/:id/whatsapp   // Enviar a WA
```

#### 3.3 Modelo de Datos (SQL)
```sql
-- Tabla de Productos
CREATE TABLE products (
  id SERIAL PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  category VARCHAR(50),
  price_usd DECIMAL(10,2),
  description TEXT,
  image_url VARCHAR(255),
  available BOOLEAN,
  created_at TIMESTAMP DEFAULT NOW()
);

-- Tabla de Pedidos
CREATE TABLE orders (
  id SERIAL PRIMARY KEY,
  items JSONB,
  total_usd DECIMAL(10,2),
  status VARCHAR(20),
  whatsapp_sent BOOLEAN,
  created_at TIMESTAMP DEFAULT NOW()
);
```

#### 3.4 Ejemplo Fetch
```javascript
// Obtener productos del backend
async function fetchProducts() {
  try {
    const response = await fetch('/api/products');
    const products = await response.json();
    renderProducts(products);
  } catch(error) {
    console.error('Error:', error);
  }
}

// Enviar pedido al backend (en lugar de directo a WA)
async function submitOrder() {
  try {
    const response = await fetch('/api/orders', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        items: cart,
        total_usd: calculateTotal(),
        customer_name: customerName,
        customer_phone: customerPhone
      })
    });
    const order = await response.json();
    console.log('Pedido creado:', order.id);
  } catch(error) {
    console.error('Error al crear pedido:', error);
  }
}
```

### Fase 4: Características Avanzadas (Largo Plazo)

- 🔐 **Autenticación**: Login de clientes + Admin panel
- 💳 **Pagos Integrados**: Stripe, Paypal, Mercado Pago
- 📊 **Dashboard Admin**: Estadísticas de pedidos, inventario
- 🔔 **Notificaciones**: Email/SMS de confirmación
- 📦 **Tracking**: Seguimiento de pedidos en tiempo real
- ⭐ **Reviews**: Sistema de calificaciones
- 🎯 **Analytics**: Google Analytics, Mixpanel
- 📱 **App Nativa**: React Native / Flutter

---

## 🔧 Mantenimiento y Mejoras

### Checklist de Deuda Técnica

- [ ] Extraer estilos CSS a archivo externo (`styles.css`)
- [ ] Separar JavaScript en módulos (`cart.js`, `products.js`, etc.)
- [ ] Agregar comentarios documentados (JSDoc)
- [ ] Crear pruebas unitarias (Jest)
- [ ] Validación de entrada en servidor (backend)
- [ ] Manejo de errores robusto (try-catch)
- [ ] Logging centralizado (Sentry, LogRocket)

### Mejoras de Performance

```javascript
// 1. Debounce en búsqueda
function debounce(func, wait) {
  let timeout;
  return function(...args) {
    clearTimeout(timeout);
    timeout = setTimeout(() => func(...args), wait);
  };
}

// 2. Lazy loading de imágenes
<img loading="lazy" src="producto.jpg">

// 3. Minificación de assets
// Usar herramientas como:
// - CSS: cssnano, PurgeCSS
// - JS: Terser, UglifyJS
// - HTML: html-minifier

// 4. Service Workers (PWA)
if('serviceWorker' in navigator) {
  navigator.serviceWorker.register('/sw.js');
}

// 5. Caché en LocalStorage
const cacheKey = `bambuchaTasa_${new Date().toDateString()}`;
const cached = localStorage.getItem(cacheKey);
if(cached) {
  TASA_CAMBIO = JSON.parse(cached);
}
```

### SEO Optimización

```html
<!-- Meta tags esenciales -->
<meta name="description" content="Menú interactivo de La Bambucha Grill Burger. Combos, hamburguesas y más.">
<meta name="keywords" content="hamburguesas, combos, grill, burger, La Bambucha">
<meta name="robots" content="index, follow">

<!-- Open Graph (Redes Sociales) -->
<meta property="og:title" content="La Bambucha Grill Burger - Menú Interactivo">
<meta property="og:description" content="Descubre nuestro delicioso menú">
<meta property="og:image" content="logo.png">
<meta property="og:url" content="https://bambucha.com">

<!-- Structured Data -->
<script type="application/ld+json">
{
  "@context": "https://schema.org/",
  "@type": "Restaurant",
  "name": "La Bambucha Grill Burger",
  "image": "logo.png",
  "address": {
    "@type": "PostalAddress",
    "addressCountry": "VE"
  },
  "telephone": "+58-4121-317635"
}
</script>
```

### Testing (Ejemplo con Jest)

```javascript
// cart.test.js
describe('Carrito', () => {
  beforeEach(() => {
    cart = [];
  });

  test('Agregar item al carrito', () => {
    addToCart(1, 'Combo', 8.00);
    expect(cart.length).toBe(1);
    expect(cart[0].quantity).toBe(1);
  });

  test('Incrementar cantidad de item existente', () => {
    addToCart(1, 'Combo', 8.00);
    addToCart(1, 'Combo', 8.00);
    expect(cart.length).toBe(1);
    expect(cart[0].quantity).toBe(2);
  });

  test('Remover item del carrito', () => {
    addToCart(1, 'Combo', 8.00);
    removeItem(1);
    expect(cart.length).toBe(0);
  });

  test('Calcular total correctamente', () => {
    addToCart(1, 'Combo', 8.00);
    addToCart(2, 'Burger', 6.50);
    const total = cart.reduce((acc, item) => acc + (item.price * item.quantity), 0);
    expect(total).toBe(14.50);
  });
});
```

---

## 📋 Resumen de Archivos

### Estructura de Carpetas (Sugerida)

```
menu-menu/
├── index.html               # Página principal
├── desarrollo/              # Versión de desarrollo
│   ├── index.html
│   └── notes.md            # Notas técnicas
├── assets/
│   ├── css/
│   │   ├── styles.css      # Estilos personalizados
│   │   └── tailwind.css    # Tailwind importado
│   ├── js/
│   │   ├── cart.js         # Lógica de carrito
│   │   ├── products.js     # Productos y filtros
│   │   └── main.js         # Inicialización
│   └── images/
│       ├── logo.svg
│       ├── products/       # Fotos de productos
│       └── ...
├── ARQUITECTURA_TECNICA.md # Este archivo
├── README.md               # Para usuarios finales
├── .gitignore
└── package.json            # Dependencias (futuro)
```

---

## 🚀 Deployments Recomendados

### Opción 1: GitHub Pages (Gratis, Estático)
```bash
git push origin main
# La rama main automáticamente publica en:
# https://manuelgocho.github.io/menu-menu
```

### Opción 2: Vercel (Gratis, con dominio propio)
```bash
npm i -g vercel
vercel --prod
# Conectar dominio custom (labambucha.com)
```

### Opción 3: Netlify (Gratis, Drag & Drop)
- Subir carpeta a Netlify
- Configurar dominio
- SSL automático

---

## 📞 Contacto y Soporte

**Negocio:**
- 📱 WhatsApp: +58 4121 317635
- 📷 Instagram: @la_bambucha_burguer

**Desarrollo:**
- 👨‍💻 GitHub: @manuelgocho
- 📧 Email: [tu-email]

---

## 📄 Control de Versiones

| Versión | Fecha | Cambios |
|---------|-------|---------|
| 1.0 | Jun 2026 | Versión inicial, carrito funcional |
| 1.1 | TBD | Agregar más productos |
| 2.0 | TBD | Backend API |
| 2.5 | TBD | Dashboard Admin |
| 3.0 | TBD | App móvil nativa |

---

**Última actualización:** Junio 2026  
**Mantener este documento actualizado es crítico para la escalabilidad futura.**

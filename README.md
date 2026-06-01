# 🍔 Menu del gocho - Sistema de Menú Interactivo

## 📋 Índice
1. [Descripción General](#descripción-general)
2. [Stack Técnico](#stack-técnico)
3. [Arquitectura](#arquitectura)
4. [Componentes](#componentes)
5. [Funcionalidades](#funcionalidades)
6. [Estructura de Datos](#estructura-de-datos)
7. [Guía de Escalabilidad](#guía-de-escalabilidad)
8. [Instalación](#instalación)
9. [Licencia](#licencia)

---

## 📱 Descripción General

**La Bambucha Grill Burger** es un sistema de menú digital interactivo diseñado para restaurantes. Permite:

- 📋 Visualización moderna del menú
- 🛒 Carrito de compras dinámico
- 💬 Sistema de notas por producto
- 💵 Conversión de moneda en tiempo real
- 📱 Integración directa con WhatsApp
- 🎨 Diseño responsive (Mobile-First)

**Versión Actual:** 1.0.0  
**Estado:** Producción  
**Última actualización:** 2026

---

## 🛠️ Stack Técnico

### Frontend
```
├── HTML5
│   ├── Semántica HTML5
│   ├── Meta tags de viewport
│   └── Accesibilidad (ARIA labels)
│
├── CSS3 (Tailwind CSS)
│   ├── Utility-first framework
│   ├── Custom CSS variables
│   ├── Gradientes y efectos
│   └── Animaciones suaves
│
└── JavaScript Vanilla
    ├── ES6+ (Arrow functions, const/let)
    ├── DOM Manipulation
    ├── Event Handling
    └── Local State Management
```

### Herramientas Externas
- **Tailwind CSS 3.x** - Framework CSS utility-first
- **Google Fonts** - Tipografía (Inter, sans-serif)
- **WhatsApp API** - Integración wa.me/

### Paleta de Colores (Aéreo Gastro Bar)
```
Primario:     #0052CC (Azul Royal)
Primario Dark: #003D99 (Azul oscuro)
Secundario:   #FFFFFF (Blanco)
Fondo:        #000000 (Negro)
Surface:      #1a1a1a (Gris oscuro)
```

---

## 🏗️ Arquitectura

### Diagrama de Flujo
```
┌─────────────────────────────────────────────────────────┐
│                    APLICACIÓN WEB                       │
└─────────────────────────────────────────────────────────┘
                         │
        ┌────────────────┼────────────────┐
        │                │                │
    ┌───▼────┐       ┌──▼────┐      ┌───▼────┐
    │ HEADER │       │ HERO  │      │ FOOTER │
    └────────┘       └───────┘      └────────┘
        │
        ├─ Logo + Branding
        ├─ Navegación (Home, Menu, Social)
        └─ Botón Carrito (con badge)

┌─────────────────────────────────────────────────────────┐
│                   SECCIÓN MENÚ                          │
├─────────────────────────────────────────────────────────┤
│  Filtros → [Todos] [Combos] [Hamburguesas]             │
│                                                         │
│  ┌──────────────────┐  ┌──────────────────┐           │
│  │  PRODUCTO 1      │  │  PRODUCTO 2      │           │
│  │  ┌─────────────┐ │  │  ┌─────────────┐ │           │
│  │  │   IMAGEN    │ │  │  │   IMAGEN    │ │           │
│  │  ├─────────────┤ │  │  ├─────────────┤ │           │
│  │  │ Nombre      │ │  │  │ Nombre      │ │           │
│  │  │ Descripción │ │  │  │ Descripción │ │           │
│  │  │ Precio USD  │ │  │  │ Precio USD  │ │           │
│  │  │ [Agregar]   │ │  │  │ [Agregar]   │ │           │
│  │  └─────────────┘ │  │  └─────────────┘ │           │
│  └──────────────────┘  └──────────────────┘           │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│                  CARRITO (Drawer)                       │
├─────────────────────────────────────────────────────────┤
│  Header: Logo + "Tu Pedido" + [Cerrar]                 │
│  ─────────────────────────────────────────────────────  │
│  Items Container:                                       │
│  ┌─────────────────────────────────────────────────┐   │
│  │ Producto 1                              [×]     │   │
│  │ $8.00 c/u  Sub: $24.00                          │   │
│  │ [-] 3 [+]          [✓] NOTA                     │   │
│  │ ┌─────────────────────────────────────────────┐ │   │
│  │ │ Textarea: Sin picante...                   │ │   │
│  │ └─────────────────────────────────────────────┘ │   │
│  │ 📝 NOTA: Sin picante...                         │   │
│  └─────────────────────────────────────────────────┘   │
│  ─────────────────────────────────────────────────────  │
│  Totales:                                               │
│  Total USD: $32.00                                      │
│  Equivalente: Bs 1,280.00                               │
│  ─────────────────────────────────────────────────────  │
│  [Enviar Pedido por WhatsApp]                           │
└─────────────────────────────────────────────────────────┘
```

---

## 🧩 Componentes

### 1. **Header (Navegación Principal)**
```html
<header class="sticky top-0 z-40">
  - Logo + Branding
  - Navegación (4 links)
  - Botón Carrito con badge contador
</header>
```
**Responsabilidades:**
- Mantener visibilidad en scroll
- Mostrar cantidad de items en carrito
- Acceso rápido a secciones principales

### 2. **Hero Section**
```html
<section id="inicio">
  - Titulo principal (h1)
  - Subtitulo
  - 2 CTA buttons
  - Círculo decorativo (visual)
</section>
```
**Responsabilidades:**
- Primer impacto visual
- Dirección a menú o WhatsApp
- Responsive grid layout

### 3. **Menu Section**
```html
<section id="menu">
  - Titulo + descripción
  - Filtros (Todos, Combos, Hamburguesas)
  - Grid de productos (1-3 columnas según pantalla)
  - Cards de producto
</section>
```
**Responsabilidades:**
- Mostrar productos
- Filtrado de categorías
- Agregar items al carrito

### 4. **Product Card**
```html
<article class="product-card">
  - Imagen/placeholder
  - Categoria badge
  - Nombre producto
  - Descripción
  - Precio (USD + Bs)
  - Botón agregar
</article>
```
**Responsabilidades:**
- Representar producto
- Mostrar información completa
- Trigger para agregar al carrito

### 5. **Cart Drawer (Lateral)**
```html
<div id="cart-drawer">
  - Overlay oscuro clickeable
  - Container deslizable (transform x)
  - Items dinámicos
  - Controls (cantidad, nota, eliminar)
  - Footer con totales y botón envío
</div>
```
**Responsabilidades:**
- Visualizar items seleccionados
- Gestionar cantidad y notas
- Calcular totales
- Integración WhatsApp

---

## ⚙️ Funcionalidades Core

### 1. **Agregar al Carrito**
```javascript
function addToCart(id, name, price) {
  // Verificar si producto ya existe
  // Si existe: incrementar cantidad
  // Si no: crear nuevo item con propiedades:
  //   - id: identificador único
  //   - name: nombre producto
  //   - price: precio USD
  //   - quantity: cantidad (default 1)
  //   - note: notas especiales (empty string)
  
  // Actualizar UI
  updateCartUI();
}
```

### 2. **Gestionar Cantidad**
```javascript
function changeQuantity(id, delta) {
  // delta puede ser +1 o -1
  // Si quantity <= 0: eliminar del carrito
  // Si cantidad > 0: actualizar
  updateCartUI();
}
```

### 3. **Sistema de Notas por Producto**
```javascript
function updateItemNote(id, noteText) {
  // Buscar item en carrito
  // Actualizar propiedad 'note'
  // Las notas se guardan en memoria (no en BD)
}
```

### 4. **Cálculo de Totales**
```javascript
// Dentro de updateCartUI():
let totalUSD = 0;
cart.forEach(item => {
  const subtotal = item.price * item.quantity;
  totalUSD += subtotal;
});

const totalBs = totalUSD * TASA_CAMBIO; // 40.00
```

### 5. **Envío por WhatsApp**
```javascript
function sendOrderWhatsApp() {
  // Construir mensaje formateado
  let message = "🍔 *NUEVO PEDIDO*\n\n";
  
  cart.forEach(item => {
    message += `• ${item.quantity}x ${item.name}...`;
    if(item.note) message += `\n   📝 ${item.note}`;
  });
  
  message += `\nTotal: $${totalUSD}`;
  
  // Abrir WhatsApp con mensaje pre-rellenado
  window.open(`https://wa.me/584121317635?text=${encodeURIComponent(message)}`);
}
```

---

## 📊 Estructura de Datos

### Array de Carrito
```javascript
const cart = [
  {
    id: 1,                          // Identificador único (number)
    name: "Combo Resuelve",         // Nombre (string)
    price: 8.00,                    // Precio USD (number)
    quantity: 3,                    // Cantidad (number)
    note: "Sin picante, quesadilla" // Notas especiales (string)
  },
  {
    id: 2,
    name: "Súper Burger",
    price: 6.50,
    quantity: 1,
    note: ""
  }
];
```

### Variables Globales
```javascript
const TASA_CAMBIO = 40.00;  // Tipo de cambio USD → Bs
let cart = [];              // Array de items
let cartOpen = false;       // Estado del carrito (boolean)
```

---

## 🚀 Guía de Escalabilidad

### Fase 1: Base Actual (HTML Estático)
✅ Menú hardcodeado en HTML  
✅ Carrito en memoria (localStorage disponible)  
✅ Sin base de datos  

### Fase 2: Backend Simple (Próxima)
```
Tecnología: Node.js + Express + MongoDB

┌──────────────────────────────────────┐
│         Frontend (HTML/JS)           │
└──────────────┬───────────────────────┘
               │ API REST
┌──────────────▼───────────────────────┐
│      API Backend (Express)           │
│  GET  /api/products                  │
│  POST /api/orders                    │
│  GET  /api/orders/:id                │
└──────────────┬───────────────────────┘
               │
┌──────────────▼───────────────────────┐
│      Base de Datos (MongoDB)         │
│  - Products                          │
│  - Orders                            │
│  - Users                             │
│  - Transactions                      │
└──────────────────────────────────────┘
```

### Fase 3: Aplicación Completa
```
┌─────────────────────────────────────┐
│    Administrador (Dashboard)         │
│  - CRUD Productos                    │
│  - Gestión Pedidos                   │
│  - Reportes/Estadísticas             │
│  - Usuarios/Roles                    │
└────────────────┬────────────────────┘
                 │
         ┌───────┼────────┐
         │                │
    ┌────▼─────┐     ┌────▼─────┐
    │  Web App  │     │ Mobile   │
    └──────────┘     │ App      │
                     └──────────┘
```

### Mejoras Técnicas por Fase

#### Fase 1 → 2: Backend
```javascript
// Antes (Hardcoded):
const products = [
  { id: 1, name: "Combo Resuelve", price: 8.00 },
  { id: 2, name: "Súper Burger", price: 6.50 }
];

// Después (API):
fetch('/api/products')
  .then(res => res.json())
  .then(data => renderProducts(data));
```

#### Fase 2 → 3: Base de Datos
```javascript
// Guardar pedido
fetch('/api/orders', {
  method: 'POST',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify({
    items: cart,
    total: totalUSD,
    timestamp: new Date(),
    customer: { phone, name }
  })
})
.then(res => res.json())
.then(data => {
  localStorage.removeItem('cart');
  window.location.href = `/order/${data.orderId}`;
});
```

### Conversión a SPA (Single Page Application)

**Opciones recomendadas:**
1. **Vue.js** (Ligero, fácil aprendizaje)
2. **React** (Más robusto, comunidad grande)
3. **Svelte** (Performante, sintaxis limpia)

**Ejemplo con Vue 3:**
```vue
<template>
  <div class="app">
    <Header :cartCount="cart.length" @open-cart="cartOpen = true" />
    <Menu @add-product="addToCart" />
    <CartDrawer 
      v-if="cartOpen" 
      :items="cart"
      @close="cartOpen = false"
      @send-order="sendOrder"
    />
  </div>
</template>

<script>
import { reactive, ref } from 'vue';
import Header from './components/Header.vue';
import Menu from './components/Menu.vue';
import CartDrawer from './components/CartDrawer.vue';

export default {
  components: { Header, Menu, CartDrawer },
  setup() {
    const cart = reactive([]);
    const cartOpen = ref(false);

    const addToCart = (product) => {
      const existing = cart.find(item => item.id === product.id);
      if (existing) {
        existing.quantity += 1;
      } else {
        cart.push({ ...product, quantity: 1, note: '' });
      }
    };

    return { cart, cartOpen, addToCart };
  }
};
</script>
```

### Performance Optimization

```javascript
// Lazy Loading de imágenes
const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      const img = entry.target;
      img.src = img.dataset.src;
      observer.unobserve(img);
    }
  });
});

document.querySelectorAll('img[data-src]').forEach(img => {
  observer.observe(img);
});

// LocalStorage para persistencia
function saveCart() {
  localStorage.setItem('cart', JSON.stringify(cart));
}

function loadCart() {
  const saved = localStorage.getItem('cart');
  return saved ? JSON.parse(saved) : [];
}

// Service Workers (PWA)
if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('/sw.js');
}
```

### Integración de Pasarela de Pago

```javascript
// Stripe integration
async function processPayment() {
  const response = await fetch('/api/create-payment', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      amount: totalUSD * 100, // centavos
      items: cart
    })
  });
  
  const { clientSecret } = await response.json();
  
  const result = await stripe.confirmCardPayment(clientSecret, {
    payment_method: {
      card: cardElement,
      billing_details: { name: customerName }
    }
  });

  if (result.paymentIntent.status === 'succeeded') {
    saveOrder();
  }
}
```

---

## 📥 Instalación

### Opción 1: Local (Desarrollo)
```bash
# 1. Clonar repositorio
git clone https://github.com/manuelgocho/menu-menu.git
cd menu-menu

# 2. Abrir en navegador
open index.html
# O usar Live Server en VS Code
```

### Opción 2: Hosting (Producción)

**Vercel (Recomendado para estática)**
```bash
# 1. Instalar Vercel CLI
npm i -g vercel

# 2. Deploy
vercel

# URL: https://menu-menu.vercel.app
```

**Netlify**
```bash
# Arrastrar carpeta a netlify.com/drop
# O conectar con GitHub
```

**Servidor propio (Nginx)**
```bash
# 1. Copiar archivos
scp index.html user@server:/var/www/bambucha/

# 2. Configurar Nginx
server {
  server_name bambucha.com;
  root /var/www/bambucha;
  index index.html;
  
  location / {
    try_files $uri $uri/ =404;
  }
}
```

---

## 🔐 Variables de Configuración

```javascript
// Editar estos valores según tu negocio:

const TASA_CAMBIO = 40.00;                    // Tipo de cambio USD/Bs
const WHATSAPP_NUMBER = "584121317635";      // Tu número WhatsApp
const CURRENCY_SYMBOL = "$";                 // Símbolo moneda
const BUSINESS_NAME = "La Bambucha";         // Nombre negocio
const LOGO_URL = "/logo.png";                // URL del logo
```

---

## 📱 Responsive Design

**Breakpoints Tailwind:**
```
sm:  640px   (tablets)
md:  768px   (tablets landscape)
lg:  1024px  (desktops)
xl:  1280px  (desktops grandes)
2xl: 1536px  (ultra-wide)
```

**Layout:**
- **Mobile (< 640px)**: Single column, header comprimido
- **Tablet (640-1024px)**: 2 columnas, nav horizontal
- **Desktop (> 1024px)**: 3 columnas, layout full

---

## 🐛 Debugging

```javascript
// Habilitar logs
const DEBUG = true;

function log(...args) {
  if (DEBUG) console.log('[LOG]', ...args);
}

// Verificar carrito
log('Cart state:', cart);

// Verificar eventos
document.addEventListener('click', (e) => {
  if (DEBUG) log('Click event:', e.target);
});

// DevTools
// F12 → Console → tipe: cart
```

---

## 📈 Métricas de Performance

**Objetivos (Google Core Web Vitals):**
- ⚡ LCP (Largest Contentful Paint): < 2.5s
- 🎯 FID (First Input Delay): < 100ms
- 💫 CLS (Cumulative Layout Shift): < 0.1

**Herramientas:**
- PageSpeed Insights
- WebPageTest
- Lighthouse (DevTools)

---

## 📄 Licencia

MIT License - Libre para uso comercial

---

## 👤 Autor

**Manuel Gocho**  
Desarrollador Full Stack  
Contact: [tu-email@example.com]

---

## 🤝 Contribuciones

Se aceptan PRs. Por favor:
1. Fork el proyecto
2. Crea una rama (`git checkout -b feature/AmazingFeature`)
3. Commit cambios (`git commit -m 'Add AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

---

## ❓ FAQ

**¿Cómo agregar más productos?**

En Fase 1 (actual), edita el HTML en la sección `<section id="menu">`. Duplica un `<article class="group...">`

**¿Cómo cambiar colores?**

Busca las clases Tailwind: `bg-blue-600`, `text-white`, etc. o edita `:root` en CSS.

**¿Funciona sin internet?**

Sí, es una SPA. Agregando Service Workers, funcionará offline.

**¿Cómo agregar pago online?**

Integra Stripe, PayPal o Mercado Pago en Fase 2 (backend).

---

## 📞 Soporte

Para preguntas o reportar bugs:  
📧 Email: [tu-email]  
💬 WhatsApp: [número]  
🐙 GitHub Issues: [enlace repo]

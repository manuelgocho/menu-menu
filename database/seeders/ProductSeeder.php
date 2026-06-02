<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Combo Resuelve',
                'description' => '5 perros normales con salchicha Delipic, cebolla, ensalada, papitas pequeñas y salsas + 1 refresco de 1 litro.',
                'price_usd' => 8.00,
                'price_bs' => 320.00,
                'category' => 'Combos',
                'image_url' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Súper Burger',
                'description' => 'Carne artesanal de 150g, pan especial, lechuga, tomate fresco, tocineta crujiente, queso cheddar y salsa secreta.',
                'price_usd' => 6.50,
                'price_bs' => 260.00,
                'category' => 'Hamburguesas',
                'image_url' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Combo Parrillero',
                'description' => 'Combinación premium: 2 hamburguesas + 3 perritos + ensalada + papas fritas + 2 refrescos.',
                'price_usd' => 15.00,
                'price_bs' => 600.00,
                'category' => 'Combos',
                'image_url' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Shawarma de Pollo',
                'description' => 'Pan árabe con pollo marinado, vegetales frescos, salsas especiales y acompañamientos.',
                'price_usd' => 7.50,
                'price_bs' => 300.00,
                'category' => 'Shawarmas',
                'image_url' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Pepito de Carne',
                'description' => 'Pan francés relleno de carne asada, cebolla, tomate y salsas a tu gusto.',
                'price_usd' => 5.50,
                'price_bs' => 220.00,
                'category' => 'Sandwiches',
                'image_url' => null,
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}

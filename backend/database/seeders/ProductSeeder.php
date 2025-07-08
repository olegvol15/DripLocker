<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Список категорій з товарами
        $categories = [
            'Kicks' => [
                ['Air Jordan 1', 'Classic basketball sneakers.', 199.99, 'jordan1.png'],
                ['Nike Dunk Low', 'Low-top casual basketball shoes.', 129.99, 'dunk-low.png'],
                ['Adidas Superstar', 'Iconic streetwear sneakers.', 109.99, 'superstar.png'],
                ['Puma RS-X', 'Chunky and stylish.', 99.99, 'rsx.png'],
                ['New Balance 550', 'Retro basketball look.', 119.99, 'nb550.png'],
            ],
            'Balls' => [
                ['Spalding NBA Ball', 'Official size and weight.', 89.99, 'spalding.png'],
                ['Wilson Evolution', 'Top indoor performance.', 74.99, 'wilson-evolution.png'],
                ['Nike Elite Ball', 'Tournament grade ball.', 79.99, 'nike-elite.png'],
                ['Molten GG7X', 'FIBA official game ball.', 84.99, 'molten.png'],
                ['UA 495', 'Durable and grippy.', 59.99, 'ua495.png'],
            ],
            'Clothes' => [
                ['Nike Hoodie', 'Comfortable and warm.', 59.99, 'hoodie.png'],
                ['Adidas Shorts', 'Breathable training shorts.', 29.99, 'shorts.png'],
                ['Jordan T-shirt', 'Classic tee with logo.', 24.99, 'tee.png'],
                ['Under Armour Pants', 'Flexible gym pants.', 39.99, 'pants.png'],
                ['Puma Jacket', 'Stylish for cold days.', 79.99, 'jacket.png'],
            ],
            'Accessories' => [
                ['Stretch Band', 'Stretchy and durable.', 9.99, 'band.png'],
                ['Foam Roller', 'Good for recovering', 25.99, 'roll.png'],
                ['Wristbands', 'Pair of sweatbands.', 9.99, 'wristbands.png'],
                ['Sleeve', 'Protect your arms.', 34.99, 'sleeve.png'],
                ['Sports Bottle', 'Stay hydrated.', 14.99, 'bottle.png'],
            ],
            'Backpacks' => [
                ['Nike Backpack', 'Stylish and durable.', 49.99, 'nike-backpack.png'],
                ['Adidas Backpack', 'Light and compact.', 39.99, 'adidas-backpack.png'],
                ['UA Backpack', 'Great for training.', 59.99, 'ua-backpack.png'],
                ['Jordan Backpack', 'Durable and cool.', 49.99, 'jordan-backpack.png'],
                ['Puma Backpack', 'Stylish and functional.', 44.99, 'puma-backpack.png'],
            ],
            'Socks' => [
                ['Nike Crew Socks', 'Pack of 3.', 14.99, 'crew.png'],
                ['Adidas Performance Socks', 'Breathable and light.', 13.99, 'adidas-socks.png'],
                ['UA HeatGear Socks', 'Great for training.', 12.99, 'ua-socks.png'],
                ['Jordan High Socks', 'Stylish and comfy.', 15.99, 'jordan-socks.png'],
                ['Puma Sport Socks', 'Perfect fit.', 11.99, 'puma-socks.png'],
            ],
        ];

        // Створити категорії та продукти
        foreach ($categories as $categoryName => $products) {
            $category = Category::firstOrCreate(['name' => $categoryName]);

            foreach ($products as [$name, $description, $price, $image]) {
                Product::create([
                    'category_id' => $category->id,
                    'name' => $name,
                    'description' => $description,
                    'price' => $price,
                    'image' => $image,
                ]);
            }
        }
    }
}


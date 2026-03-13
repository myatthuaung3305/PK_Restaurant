<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Pandan Admin',
                'password' => Hash::make('admin12345'),
                'is_admin' => true,
            ]
        );

        $items = [
            ['Burmese Coconut Noodle Soup', 'Breakfast', 'Classic coconut noodle soup', 7.00, 'assets/images/CoconutNoodles.webp'],
            ['Mohinga-Fish Noodle Soup', 'Breakfast', 'Traditional fish noodle soup', 7.00, 'assets/images/Mohinga.webp'],
            ['Nan Gyi Thoke', 'Breakfast', 'Thick rice noodle salad', 7.00, 'assets/images/NanGyiThoke.webp'],
            ['Caramelized Pork Belly', 'Meals', 'Sweet and savory pork belly', 8.00, 'assets/images/prokcurry.webp'],
            ['Egg Chickpea and Vegetable Stew', 'Meals', 'Comforting home-style stew', 7.00, 'assets/images/vegetablestrew.webp'],
            ['Good Ol Beef Stew', 'Meals', 'Slow-cooked beef stew', 8.00, 'assets/images/beef_stew.webp'],
            ['Grandmas Burmese Potato Chips', 'Sides', 'Crunchy potato chips', 5.00, 'assets/images/potatochip.webp'],
            ['Husband and Wife Snack', 'Sides', 'Popular Burmese snack', 5.00, 'assets/images/H&W_snack.webp'],
            ['Burmese Pork Balls', 'Sides', 'Fried pork balls with spices', 6.00, 'assets/images/porkball.webp'],
            ['Burmese Milk Tea', 'Drinks', 'Milk tea with rich flavor', 2.00, 'assets/images/Tea.webp'],
            ['Burmese Coffee', 'Drinks', 'Strong Burmese coffee', 2.00, 'assets/images/Coffee.webp'],
            ['Iced Milo Dinosaur', 'Drinks', 'Iced milo topped with powder', 2.50, 'assets/images/Milo_Dinosaur.webp'],
        ];

        foreach ($items as [$name, $category, $description, $price, $imagePath]) {
            MenuItem::query()->updateOrCreate(
                ['name' => $name],
                [
                    'category' => $category,
                    'description' => $description,
                    'price' => $price,
                    'image_path' => $imagePath,
                    'is_active' => true,
                ]
            );
        }
    }
}

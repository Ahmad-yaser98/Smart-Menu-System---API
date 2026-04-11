<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Table;
use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. حساب المدير
        User::factory()->create([
            'name' => 'المدير العام',
            'email' => 'admin@test.com',
            'password' => Hash::make('123456'),
            'role' => 'admin',
        ]);

        // 2. حساب النادل (الكابتن)
        User::factory()->create([
            'name' => 'نادل المطعم',
            'email' => 'waiter@test.com',
            'password' => Hash::make('123456'),
            'role' => 'waiter',
        ]);

        // 3. حساب المطبخ (الشيف)
        User::factory()->create([
            'name' => 'شيف المطبخ',
            'email' => 'kitchen@test.com',
            'password' => Hash::make('123456'),
            'role' => 'kitchen',
        ]);

        // 4. حساب الكاشير
        User::factory()->create([
            'name' => 'كاشير المطعم',
            'email' => 'cashier@test.com',
            'password' => Hash::make('123456'),
            'role' => 'cashier',
        ]);

        // 5. إنشاء طاولات وأصناف وقوائم طعام وهمية بناءً على المصانع (Factories)
        Table::factory(10)->create();

        Category::factory(5)->create()->each(function ($category) {
            MenuItem::factory(4)->create(['category_id' => $category->id]);
        });
    }
}
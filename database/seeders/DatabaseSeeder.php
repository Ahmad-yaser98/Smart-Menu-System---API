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
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => Hash::make('123456'),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Ahmed Waiter',
            'email' => 'waiter@test.com',
            'password' => Hash::make('123456'),
            'role' => 'waiter'
        ]);

        Table::factory(10)->create();

        Category::factory(5)->create()->each(function ($category) {
            MenuItem::factory(4)->create(['category_id' => $category->id]);
        });
    }
}
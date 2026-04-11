<?php

namespace Database\Factories;

use App\Models\MenuItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MenuItem>
 */
class MenuItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $meals = ['شاورما عربي', 'بروستد', 'بيتزا مارغريتا', 'همبرغر', 'بطاطا مقلية', 'كبة', 'تبولة', 'حمص', 'عصير برتقال', 'بيبسي'];
        
        return [
            'category_id' => \App\Models\Category::factory(), 
            'name' => $this->faker->randomElement($meals) . ' ' . $this->faker->numberBetween(1, 100),
            'price' => $this->faker->randomFloat(2, 5, 50),
            'is_available' => true,
        ];
    }
 }

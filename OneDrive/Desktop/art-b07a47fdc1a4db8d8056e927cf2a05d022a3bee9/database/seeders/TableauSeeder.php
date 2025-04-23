<?php

namespace Database\Seeders;

use App\Models\Tableau;
use App\Models\Category;
use Illuminate\Database\Seeder;

class TableauSeeder extends Seeder
{
    public function run(): void
    {
        // First, create some categories if they don't exist
        $categories = [
            ['name' => 'Traditionnel', 'slug' => 'traditionnel'],
            ['name' => 'Moderne', 'slug' => 'moderne'],
            ['name' => 'Calligraphie', 'slug' => 'calligraphie'],
            ['name' => 'Abstrait', 'slug' => 'abstrait'],
            ['name' => 'Paysage', 'slug' => 'paysage'],
            ['name' => 'Portrait', 'slug' => 'portrait'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => $category['slug']],
                ['name' => $category['name']]
            );
        }

        // Now create tableaux with proper category_id references
        $tableaux = [
            [
                'title' => 'Médina de Fès',
                'description' => 'Une vue authentique de la médina de Fès...',
                'category_id' => Category::where('slug', 'traditionnel')->first()->id,
                'price' => 2499.99,
                'image' => 'placeholder-1.jpg',
            ],
            // ... other tableaux
        ];

        foreach ($tableaux as $tableau) {
            Tableau::create($tableau);
        }
    }
}
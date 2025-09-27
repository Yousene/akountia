<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        $title = $this->faker->unique()->sentence(3);
        $image = ['categorie1.jpg', 'categorie2.jpg', 'categorie3.jpg', 'categorie4.jpg', 'categorie5.jpg','categorie6.jpg','categorie7.jpg','categorie8.jpg','categorie9.jpg','categorie10.jpg','categorie11.jpg','categorie12.jpg','categorie13.jpg'];
        $image = $this->faker->randomElement($image);

        return [
            'name' => $title,
            'link' => Str::slug($title),
            'short_description' => $this->faker->paragraph(1),
            'description' => $this->faker->paragraphs(4, true),
            'background_image' => 'assets/images/categories/'.$image,
            'icon_image' => 'assets/images/categories/'.$image,
            'deleted' => 0,
            'deleted_at' => null,
            'deleted_by' => null,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

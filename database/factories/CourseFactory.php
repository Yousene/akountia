<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CourseFactory extends Factory
{
    protected $model = Course::class;

    public function definition()
    {
        $title = $this->faker->unique()->sentence(4);
        $durationUnits = ['jours', 'heures', 'semaines', 'mois'];
        $image = ['formation1.jpg', 'formation2.jpg', 'formation3.jpg', 'formation4.jpg', 'formation5.jpg', 'formation6.jpg', 'formation7.jpg', 'formation8.jpg', 'formation9.jpg', 'formation10.jpg', 'formation11.jpg', 'formation12.jpg', 'formation13.jpg'];
        $image = $this->faker->randomElement($image);

        return [
            'category_id' => Category::factory(),
            'name' => $title,
            'link' => Str::slug($title),
            'short_description' => $this->faker->paragraph(4, true),
            'description' => $this->faker->paragraphs(8, true),
            'duration' => $this->faker->randomNumber(2, 1, 100),
            'duration_unit' => $this->faker->randomElement($durationUnits),
            'objectives' => $this->faker->paragraphs(2, true),
            'target_audience' => $this->faker->paragraphs(2, true),
            'prerequisites' => $this->faker->paragraphs(2, true),
            'teaching_methods' => $this->faker->paragraphs(2, true),
            'icon_image' => 'assets/images/formations/' . $image,
            'sidebar_image' => 'assets/images/formations/' . $image,
            'description_image' => 'assets/images/formations/' . $image,
            'is_certified' => $this->faker->boolean(),
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

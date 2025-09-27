<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition()
    {
        $name = $this->faker->company();
        $images = [
            'client1.webp',
            'client2.webp',
            'client3.webp',
            'client4.webp',
            'client5.webp',
            'client6.webp',
            'client7.webp',
            'client8.webp',
            'client9.webp',
            'client10.webp',
            'client11.webp',
            'client12.webp',
            'client13.webp',
            'client14.webp',
            'client15.webp',
            'client16.webp'
        ];
        $image = $this->faker->randomElement($images);

        return [
            'name' => $name,
            'icon_image' => 'assets/images/clients/icons/' . $image,
            'image' => 'assets/images/clients/' . $image,
            'link' => $this->faker->url(),
            // 'is_priority' => false,
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

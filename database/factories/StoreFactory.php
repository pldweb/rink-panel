<?php

namespace Database\Factories;

use App\Helper\ImageHelpers\ImageHelper;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoreFactory extends Factory
{

    protected $model = Store::class;

    public function definition(): array
    {

        $imageHelper = new ImageHelper;

        return [
            'user_id' => User::factory(),
            'name' => $this->faker->name(),
            'logo' => $imageHelper->storeAndResizeImage(
                $imageHelper->createDummyImageWithTextSizeAndPosition(250, 250, 'center', 'center', 'random', 'medium'),
                'store',
                250,
                250
            ),
            'about' => $this->faker->paragraph(),
            'phone' => $this->faker->phoneNumber(),
            'address_id' => $this->faker->numberBetween(1, 100),
            'city' => $this->faker->city(),
            'address' => $this->faker->address(),
            'postal_code' => $this->faker->postcode(),
            'is_verified' => $this->faker->boolean(70),
        ];
    }
}

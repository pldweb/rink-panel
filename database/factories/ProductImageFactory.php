<?php

namespace Database\Factories;

use App\Helper\ImageHelpers\ImageHelper;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductImage>
 */
class ProductImageFactory extends Factory
{
    protected $model = ProductImage::class;

    public function definition(): array
    {
        $imageHelper = new ImageHelper;

        return [
            'product_id' => Product::factory(),
            'image' => $imageHelper->storeAndResizeImage(
                $imageHelper->createDummyImageWithTextSizeAndPosition(250, 250, 'center', 'center', 'random', 'large'),
                'product',
                800,
                800
            ),
            'is_thumbnail' => false,
        ];
    }

    public function thumbnail(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_thumbnail' => true,
        ]);
    }
}

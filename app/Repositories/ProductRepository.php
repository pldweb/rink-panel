<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAll(?string $search, ?string $productCategoryId, ?int $limit, bool $execute)
    {
        $query = Product::where(function ($query) use ($search, $productCategoryId) {
            if ($search) {
                $query->search($search);
            }

            if ($productCategoryId) {
                $query->where('product_category_id', $productCategoryId);
            }

        })->with('productImages');

        if ($limit) {
            $query->take($limit);
        }

        if ($execute) {
            return $query->get();
        }

        return $query;
    }

    public function getAllPaginated(?string $search, ?string $productCategoryId, ?int $rowPerPage)
    {
        $query = $this->getAll($search, $productCategoryId, null, false);

        return $query->paginate($rowPerPage);
    }

    public function getById(string $id)
    {
        $query = Product::where('id', $id)->with(['productImages', 'productReviews']);

        return $query->first();
    }

    public function getBySlug(string $slug)
    {
        $query = Product::where('slug', $slug)->with('productImages');

        return $query->first();
    }

    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $product = new Product;
            $product->store_id = $data['store_id'];
            $product->product_category_id = $data['product_category_id'];
            $product->name = $data['name'];
            $product->slug = Str::slug($data['name']).'-i'.rand(10000, 99999).'.'.rand(10000000, 99999999);
            $product->description = $data['description'];
            $product->condition = $data['condition'];
            $product->price = $data['price'];
            $product->weight = $data['weight'];
            $product->stock = $data['stock'];

            $product->save();

            $productImage = new ProductImageRepository;
            if (isset($data['product_images'])) {
                foreach ($data['product_images'] as $image) {
                    $productImage->create([
                        'product_id' => $product->id,
                        'image' => $image['image'],
                        'is_thumbnail' => $image['is_thumbnail'],
                    ]);
                }
            }

            DB::commit();

            return $product;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new Exception($exception->getMessage());
        }
    }

    public function update(string $id, array $data)
    {
        DB::beginTransaction();
        try {
            $product = Product::find($id);
            $product->store_id = $data['store_id'];
            $product->product_category_id = $data['product_category_id'];
            $product->name = $data['name'];
            $product->slug = Str::slug($data['name']).'-i'.rand(10000, 99999).'.'.rand(10000000, 99999999);
            $product->description = $data['description'];
            $product->condition = $data['condition'];
            $product->price = $data['price'];
            $product->weight = $data['weight'];
            $product->stock = $data['stock'];

            $product->save();

            $productImage = new ProductImageRepository;
            if (isset($data['delete_product_images'])) {
                foreach ($data['delete_product_images'] as $image) {
                    $productImage->delete($image);
                }
            }
            if (isset($data['product_images'])) {
                foreach ($data['product_images'] as $image) {
                    if (! isset($productImage['id'])) {
                        $productImage->create([
                            'product_id' => $product->id,
                            'image' => $image['image'],
                            'is_thumbnail' => $image['is_thumbnail'],
                        ]);
                    }
                }
            }

            DB::commit();

            return $product;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new Exception($exception->getMessage());
        }
    }

    public function delete(string $id)
    {
        DB::beginTransaction();
        try {
            $product = Product::find($id);
            if (! $product) {
                throw new Exception('Kategori produk not found');
            }
            $product->delete();
            DB::commit();

            return $product;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new Exception($exception->getMessage());
        }
    }
}

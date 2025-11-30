<?php

namespace App\Repositories;

use App\Interfaces\BuyerRepositoryInterface;
use App\Interfaces\ProductImageRepositoryInterface;
use App\Interfaces\ProductRepositoryInterface;
use App\Models\Buyer;
use App\Models\Product;
use App\Models\ProductImage;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use function PHPUnit\Framework\throwException;

class ProductImageRepository implements ProductImageRepositoryInterface
{
    public function create(array $data)
    {
        DB::beginTransaction();

    }

    public function delete($id)
    {
        DB::beginTransaction();
    }
}

<?php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\StoreBalance;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{

    public function run(): void
    {
        Store::factory()->count(10)->create()->each(function ($store) {
            StoreBalance::factory()->create([
                'store_id' => $store->id,
            ]);
        });
    }
}

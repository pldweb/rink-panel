<?php

namespace Database\Seeders;

use App\Models\Buyer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BuyerSeeder extends Seeder
{

    public function run(): void
    {
        Buyer::factory()->count(10)->create();
    }
}

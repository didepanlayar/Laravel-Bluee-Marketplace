<?php

namespace Database\Seeders;

use Database\Factories\StoreFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StoreFactory::new()->count(10)->create();
    }
}

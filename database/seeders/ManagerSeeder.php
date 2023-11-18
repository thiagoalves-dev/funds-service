<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Company;
use Illuminate\Database\Seeder;

class ManagerSeeder extends Seeder
{
    public function run(): void
    {
        Company::factory()->count(10)->create();
    }
}

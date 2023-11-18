<?php

use Database\Seeders\CompanySeeder;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Artisan::call('db:seed', [
            '--class' => CompanySeeder::class,
            '--force' => true,
        ]);
    }
};

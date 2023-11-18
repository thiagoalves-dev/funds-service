<?php

use Database\Seeders\ManagerSeeder;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Artisan::call('db:seed', [
            '--class' => ManagerSeeder::class,
            '--force' => true,
        ]);
    }
};

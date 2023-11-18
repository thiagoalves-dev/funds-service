<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('funds', function (Blueprint $table) {
            $table->increments('id');

            $table->bigInteger('manager_id')
                ->index('fk_funds_manager_id');

            $table->string('name');
            $table->smallInteger('start_year');
            $table->json('aliases');

            $table
                ->foreign('manager_id')
                ->references('id')
                ->on('managers');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('funds');
    }
};

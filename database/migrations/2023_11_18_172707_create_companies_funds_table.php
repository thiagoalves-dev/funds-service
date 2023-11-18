<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('companies_funds', function (Blueprint $table) {
            $table->bigInteger('company_id')
                ->index('fk_funds_fund_company_id');

            $table->bigInteger('fund_id')
                ->index('fk_funds_fund_id');

            $table
                ->foreign('company_id')
                ->references('id')
                ->on('companies');

            $table
                ->foreign('fund_id')
                ->references('id')
                ->on('funds');

            $table->primary(['company_id', 'fund_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies_funds');
    }
};

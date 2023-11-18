<?php

namespace Feature\Http\Controllers\Api;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CompanyControllerTest extends TestCase
{
    use DatabaseMigrations;
    
    public function testIndexSuccess(): void
    {
        $this
            ->get(route('api.companies.index'))
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                    ],
                ],
            ]);
    }
}

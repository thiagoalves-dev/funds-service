<?php

namespace Feature\Http\Controllers\Api;

use Tests\TestCase;

class CompanyControllerTest extends TestCase
{
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

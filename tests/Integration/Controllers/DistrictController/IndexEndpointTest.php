<?php

declare(strict_types=1);

namespace VOSTPT\Tests\Integration\Controllers\DistrictController;

use Illuminate\Foundation\Testing\RefreshDatabase;
use VOSTPT\Tests\Integration\TestCase;

class IndexEndpointTest extends TestCase
{
    use RefreshDatabase;

    /**
     * {@inheritDoc}
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed', [
            '--class' => 'DistrictSeeder',
        ]);
    }

    /**
     * @test
     */
    public function itFailsToIndexDistrictsDueToInvalidContentTypeHeader(): void
    {
        $response = $this->json('GET', route('districts::index'));

        $response->assertHeader('Content-Type', 'application/vnd.api+json');
        $response->assertStatus(415);
        $response->assertJson([
            'errors' => [
                [
                    'status' => 415,
                    'detail' => 'Wrong media type',
                ],
            ],
        ]);
    }

    /**
     * @test
     */
    public function itFailsToIndexDistrictsDueToValidation(): void
    {
        $response = $this->json('GET', route('districts::index'), [
            'page' => [
                'number' => 'second',
                'size'   => 'ten',
            ],
            'search' => '',
            'sort'   => 'id',
            'order'  => 'up',
        ], [
            'Content-Type' => 'application/vnd.api+json',
        ]);

        $response->assertHeader('Content-Type', 'application/vnd.api+json');
        $response->assertStatus(422);
        $response->assertJson([
            'errors' => [
                [
                    'detail' => 'The page.number must be an integer.',
                    'meta'   => [
                        'field' => 'page.number',
                    ],
                ],
                [
                    'detail' => 'The page.size must be an integer.',
                    'meta'   => [
                        'field' => 'page.size',
                    ],
                ],
                [
                    'detail' => 'The search must be a string.',
                    'meta'   => [
                        'field' => 'search',
                    ],
                ],
                [
                    'detail' => 'The selected sort is invalid.',
                    'meta'   => [
                        'field' => 'sort',
                    ],
                ],
                [
                    'detail' => 'The selected order is invalid.',
                    'meta'   => [
                        'field' => 'order',
                    ],
                ],
            ],
        ]);
    }

    /**
     * @test
     */
    public function itSuccessfullyIndexesDistricts(): void
    {
        $response = $this->json('GET', route('districts::index'), [
            'deleted' => true,
            'page'    => [
                'number' => 2,
                'size'   => 2,
            ],
            'search' => '0 1 2 3 4 5 6 7 8 9',
            'sort'   => 'code',
            'order'  => 'asc',
        ], [
            'Content-Type' => 'application/vnd.api+json',
        ]);

        $response->assertHeader('Content-Type', 'application/vnd.api+json');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'links' => [
                'first',
                'last',
                'prev',
                'next',
            ],
            'data' => [
                '*' => [
                    'type',
                    'id',
                    'attributes' => [
                        'code',
                        'name',
                        'created_at',
                        'updated_at',
                    ],
                    'links' => [
                        'self',
                    ],
                ],
            ],
            'meta' => [
                'per_page',
                'total',
            ],
        ]);
    }
}

<?php

namespace Tests\Feature;

use App\Jobs\ExportProductsJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ExportProductsJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_export_products_job_dispatched(): void
    {
        Queue::fake();
        $response = $this->postJson('/api/v1/products/export');
        $response->assertOk();
        Queue::assertPushed(ExportProductsJob::class);
    }
}

<?php

namespace Tests\Unit;

use App\Contracts\ProductRepositoryInterface;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use Mockery;
use PHPUnit\Framework\TestCase;

class ProductServiceTest extends TestCase
{
    use WithFaker;

    protected ProductRepositoryInterface $mockRepository;
    protected ProductService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockRepository = Mockery::mock(ProductRepositoryInterface::class);
        $this->service = new ProductService($this->mockRepository);
    }

    public function test_get_all_products(): void
    {
        $products = new Collection([new Product(['name' => 'Test'])]);

        $this->mockRepository
            ->shouldReceive('all')
            ->once()
            ->andReturn($products);

        $result = $this->service->getAll();

        $this->assertCount(1, $result);
        $this->assertEquals('Test', $result->first()->name);
    }

    public function test_get_by_id_success(): void
    {
        $product = new Product(['id' => 1, 'name' => 'Test']);

        $this->mockRepository
            ->shouldReceive('find')
            ->with(1)
            ->once()
            ->andReturn($product);

        $result = $this->service->getById(1);

        $this->assertEquals('Test', $result->name);
    }

    public function test_get_by_id_not_found(): void
    {
        $this->mockRepository
            ->shouldReceive('find')
            ->with(999)
            ->once()
            ->andReturn(null);

        $result = $this->service->getById(999);

        $this->assertNull($result);
    }

    public function test_store_product(): void
    {
        $data = [
            'name' => 'New Product',
            'price' => 150.00,
            'barcode' => '1234567890123',
            'category_id' => 1
        ];

        $product = new Product($data);

        $this->mockRepository
            ->shouldReceive('create')
            ->with($data)
            ->once()
            ->andReturn($product);

        $result = $this->service->store($data);

        $this->assertEquals('New Product', $result->name);
        $this->assertEquals(150.00, $result->price);
    }

    public function test_update_product(): void
    {
        $product = new Product([
            'id' => 1,
            'name' => 'Old Name',
            'price' => 100,
            'barcode' => '1234567890123',
            'category_id' => 1,
        ]);

        $updatedData = ['price' => 200];

        $product->fill($updatedData);

        $this->mockRepository
            ->shouldReceive('update')
            ->with($product, $updatedData)
            ->once()
            ->andReturn($product);

        $result = $this->service->update($product, $updatedData);

        $this->assertEquals(200, $result->price);
    }

    public function test_delete_product(): void
    {
        $product = new Product(['id' => 1]);

        $this->mockRepository
            ->shouldReceive('delete')
            ->with($product)
            ->once()
            ->andReturn(true);

        $this->assertTrue($this->service->destroy($product));
    }

    public function test_delete_product_failed(): void
    {
        $product = new Product(['id' => 2]);

        $this->mockRepository
            ->shouldReceive('delete')
            ->with($product)
            ->once()
            ->andReturn(false);

        $this->assertFalse($this->service->destroy($product));
    }
}

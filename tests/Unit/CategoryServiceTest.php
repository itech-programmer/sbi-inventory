<?php

namespace Tests\Unit;

use App\Contracts\Category\CategoryRepositoryInterface;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Support\Collection;
use Mockery;
use PHPUnit\Framework\TestCase;

class CategoryServiceTest extends TestCase
{
    protected CategoryRepositoryInterface $mockRepository;
    protected CategoryService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockRepository = Mockery::mock(CategoryRepositoryInterface::class);
        $this->service = new CategoryService($this->mockRepository);
    }

    public function test_get_all_categories(): void
    {
        $categories = new Collection([new Category(['name' => 'Phones'])]);

        $this->mockRepository
            ->shouldReceive('all')
            ->once()
            ->andReturn($categories);

        $result = $this->service->getAll();

        $this->assertCount(1, $result);
        $this->assertEquals('Phones', $result->first()->name);
    }

    public function test_get_all_categories_empty(): void
    {
        $this->mockRepository
            ->shouldReceive('all')
            ->once()
            ->andReturn(collect());

        $result = $this->service->getAll();

        $this->assertCount(0, $result);
    }

    public function test_get_category_by_id_success(): void
    {
        $category = new Category(['id' => 1, 'name' => 'Chargers']);

        $this->mockRepository
            ->shouldReceive('find')
            ->with(1)
            ->once()
            ->andReturn($category);

        $result = $this->service->getById(1);

        $this->assertEquals('Chargers', $result->name);
    }

    public function test_get_category_by_id_not_found(): void
    {
        $this->mockRepository
            ->shouldReceive('find')
            ->with(999)
            ->once()
            ->andReturn(null);

        $result = $this->service->getById(999);

        $this->assertNull($result);
    }

    public function test_store_category(): void
    {
        $data = ['name' => 'Cases'];
        $category = new Category($data);

        $this->mockRepository
            ->shouldReceive('create')
            ->with($data)
            ->once()
            ->andReturn($category);

        $result = $this->service->store($data);

        $this->assertEquals('Cases', $result->name);
    }

    public function test_update_category(): void
    {
        $category = new Category(['name' => 'Old Name']);
        $updatedData = ['name' => 'New Name'];

        $category->fill($updatedData);

        $this->mockRepository
            ->shouldReceive('update')
            ->with($category, $updatedData)
            ->once()
            ->andReturn($category);

        $result = $this->service->update($category, $updatedData);

        $this->assertEquals('New Name', $result->name);
    }

    public function test_destroy_category_success(): void
    {
        $category = new Category(['id' => 1]);

        $this->mockRepository
            ->shouldReceive('delete')
            ->with($category)
            ->once()
            ->andReturn(true);

        $this->assertTrue($this->service->destroy($category));
    }

    public function test_destroy_category_failed(): void
    {
        $category = new Category(['id' => 1]);

        $this->mockRepository
            ->shouldReceive('delete')
            ->with($category)
            ->once()
            ->andReturn(false);

        $this->assertFalse($this->service->destroy($category));
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}

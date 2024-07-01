<?php

namespace Tests\Unit\ProductPackaging;

use App\Models\Box;
use App\Models\Product;
use App\Service\PackagingService;
use PHPUnit\Framework\TestCase;
use Exception;

class PackagingServiceTest extends TestCase
{
    private PackagingService $packagingService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->packagingService = new PackagingService();
    }

    public function testSingleSmallProduct()
    {
        $products = [new Product(10, 10, 10, 1, 1)];
        $result = $this->packagingService->selectPackaging($products);

        $this->assertCount(1, $result);
        $this->assertEquals('BOXA', $result[0]['box']->name);
    }

    public function testMultipleSmallProducts()
    {
        $products = [
            new Product(10, 10, 10, 1, 3),
            new Product(5, 5, 5, 1, 2)
        ];
        $result = $this->packagingService->selectPackaging($products);

        $this->assertCount(1, $result);
        $this->assertEquals('BOXB', $result[0]['box']->name);
        $this->assertCount(5, $result[0]['products']);
    }

    public function testProductsThatRequireMultipleBoxes()
    {
        $products = [
            new Product(40, 40, 40, 40, 1),
            new Product(10, 10, 10, 10, 2),
            new Product(30, 30, 30, 10, 1)
        ];
        $result = $this->packagingService->selectPackaging($products);

        $this->assertCount(2, $result);
        $this->assertEquals('BOXC', $result[0]['box']->name);
        $this->assertEquals('BOXD', $result[1]['box']->name);
    }


    public function testProductTooLargeForAnyBox()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Unable to pack all products. Largest product doesn't fit in any box.");

        $products = [new Product(70, 60, 55, 60, 1)];
        $this->packagingService->selectPackaging($products);
    }
}

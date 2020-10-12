<?php

declare(strict_types = 1);

namespace Test\Service\Product;

use Model\Entity\Product as ProductEntity;
use Model\Repository\Product as ProductRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Service\Product\Product as ProductService;

class ProductTest extends TestCase
{
    /**
     * @dataProvider dataProviderProduct
     *
     * @param ProductEntity[] $productEntities
     */
    public function testGetOneProduct(array $productEntities)
    {
        $productRepository = $this->getMockBuilder(ProductRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $productRepository->method('search')
            ->willReturn($productEntities);

        /** @var ProductService|MockObject $productService */
        $productService = $this->getMockBuilder(ProductService::class)
            ->disableOriginalConstructor()
            ->setMethods(['getProductRepository'])
            ->getMock();

        $productService->method('getProductRepository')
            ->willReturn($productRepository);

        $product = $productService->getInfo(10);

        $this->assertEquals(current($productEntities), $product);
    }

    /**
     * @return \Generator
     */
    public function dataProviderProduct(): \Generator
    {
        yield 'empty product list' => [
            [
            ]
        ];

        yield 'product list' => [
            [
                new ProductEntity(3, 'Another', 50.11, 'Description'),
            ]
        ];
    }

    /**
     * @dataProvider dataProviderAllProduct
     *
     * @param ProductEntity[] $productEntities
     */
    public function testGetAllProducts(array $productEntities)
    {
        $productRepository = $this->getMockBuilder(ProductRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $productRepository->method('fetchAll')
            ->willReturn($productEntities);

        /** @var ProductService|MockObject $productService */
        $productService = $this->getMockBuilder(ProductService::class)
            ->disableOriginalConstructor()
            ->setMethods(['getProductRepository'])
            ->getMock();

        $productService->method('getProductRepository')
            ->willReturn($productRepository);

        $productList = $productService->getAll('test');

        $this->assertEquals($productEntities, $productList);
    }

    /**
     * @return \Generator
     */
    public function dataProviderAllProduct(): \Generator
    {
        yield 'empty product list' => [
            [
            ]
        ];

        yield 'product list' => [
            [
                new ProductEntity(3, 'Another', 50.11, 'Descr'),
                new ProductEntity(10, 'Test', 199.99, '1'),
            ]
        ];

        yield 'product list with extreme values' => [
            [
                new ProductEntity(0, '', 0, ""),
                new ProductEntity(PHP_INT_MAX, 'Test', 1.7976931348623e+308, ''),
            ]
        ];
    }
}

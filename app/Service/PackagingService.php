<?php

declare(strict_types=1);

namespace App\Service;

use App\Models\Box;
use App\Models\Product;
use Exception;

class PackagingService
{
    /** @var Box[] */
    private array $boxes;

    public function __construct()
    {
        $this->boxes = $this->loadBoxes();
    }

    private function loadBoxes(): array
    {
        $boxes = array_map(
            [Box::class, 'createFromConfiguration'],
            Box::getBoxConfigurations()
        );

        usort($boxes, function (Box $a, Box $b): int {
            $volumeA = $a->length * $a->width * $a->height;
            $volumeB = $b->length * $b->width * $b->height;
            return $volumeA <=> $volumeB;
        });

        return $boxes;
    }

    /**
     * @param Product[] $products
     * @return array<int, array{box: Box, products: Product[]}>
     * @throws Exception
     */
    public function selectPackaging(array $products): array
    {
        $result = [];
        $remainingProducts = $this->flattenProducts($products);

        while (!empty($remainingProducts)) {
            $box = $this->findSmallestSuitableBox($remainingProducts);
            if (!$box) {
                $largestProduct = $this->getLargestProduct($remainingProducts);
                $boxForLargest = $this->findSmallestSuitableBox([$largestProduct]);
                if (!$boxForLargest) {
                    throw new Exception("Unable to pack all products. Largest product doesn't fit in any box.");
                }
                $result[] = ['box' => $boxForLargest, 'products' => [$largestProduct]];
                $remainingProducts = array_values($this->arrayDiffProducts($remainingProducts, [$largestProduct]));
            } else {
                $packedProducts = $this->packProducts($box, $remainingProducts);
                $result[] = ['box' => $box, 'products' => $packedProducts];
                $remainingProducts = array_values($this->arrayDiffProducts($remainingProducts, $packedProducts));
            }
        }

        return $result;
    }


    private function arrayDiffProducts(array $array1, array $array2): array
    {
        return array_udiff($array1, $array2, function ($a, $b) {
            return strcmp((string) $a, (string) $b);
        });
    }

    /**
     * @param Product[] $products
     * @return Product[]
     */
    private function flattenProducts(array $products): array
    {
        $flattenedProducts = [];

        foreach ($products as $product) {
            for ($i = 0; $i < $product->quantity; $i++) {
                $flattenedProducts[] = new Product(
                    $product->length,
                    $product->width,
                    $product->height,
                    $product->weight,
                    1
                );
            }
        }

        return $flattenedProducts;
    }

    /**
     * @param Product[] $products
     */
    private function findSmallestSuitableBox(array $products): ?Box
    {
        $totalVolume = $this->calculateTotalVolume($products);
        $totalWeight = $this->calculateTotalWeight($products);
        $maxDimensions = $this->getMaxDimensions($products);

        foreach ($this->boxes as $box) {
            if ($this->canFitInBox($totalVolume, $totalWeight, $maxDimensions, $box)) {
                return $box;
            }
        }

        return null;
    }

    private function canFitInBox(float $totalVolume, float $totalWeight, array $maxDimensions, Box $box): bool
    {
        $boxVolume = $box->length * $box->width * $box->height;
        return $totalVolume <= $boxVolume &&
            $totalWeight <= $box->weight_limit &&
            $maxDimensions['length'] <= $box->length &&
            $maxDimensions['width'] <= $box->width &&
            $maxDimensions['height'] <= $box->height;
    }

    /**
     * @param Product[] $products
     */
    private function calculateTotalVolume(array $products): float
    {
        return array_reduce($products, function (float $carry, Product $product): float {
            return $carry + ($product->length * $product->width * $product->height);
        }, 0.0);
    }

    /**
     * @param Product[] $products
     */
    private function calculateTotalWeight(array $products): float
    {
        return array_reduce($products, function (float $carry, Product $product): float {
            return $carry + $product->weight;
        }, 0.0);
    }

    /**
     * @param Product[] $products
     * @return array<string, float>
     */
    private function getMaxDimensions(array $products): array
    {
        $maxLength = $maxWidth = $maxHeight = 0.0;
        foreach ($products as $product) {
            $maxLength = max($maxLength, $product->length);
            $maxWidth = max($maxWidth, $product->width);
            $maxHeight = max($maxHeight, $product->height);
        }
        return ['length' => $maxLength, 'width' => $maxWidth, 'height' => $maxHeight];
    }

    /**
     * @param Product[] $products
     */
    private function getLargestProduct(array $products): Product
    {
        return array_reduce($products, function (?Product $carry, Product $product): Product {
            if ($carry === null) {
                return $product;
            }

            $currentVolume = $product->length * $product->width * $product->height;
            $carryVolume = $carry->length * $carry->width * $carry->height;

            // If volumes are significantly different, use volume comparison
            if (abs($currentVolume - $carryVolume) > 0.001) {
                return $currentVolume > $carryVolume ? $product : $carry;
            }

            // If volumes are very close, use weight as a tiebreaker
            return $product->weight > $carry->weight ? $product : $carry;
        });
    }

    /**
     * @param Box $box
     * @param Product[] $products
     * @return Product[]
     */
    private function packProducts(Box $box, array $products): array
    {
        $packedProducts = [];
        $remainingVolume = $box->length * $box->width * $box->height;
        $remainingWeight = $box->weight_limit;

        foreach ($products as $product) {
            $productVolume = $product->length * $product->width * $product->height;
            if ($productVolume <= $remainingVolume && $product->weight <= $remainingWeight) {
                $packedProducts[] = $product;
                $remainingVolume -= $productVolume;
                $remainingWeight -= $product->weight;
            }
        }

        return $packedProducts;
    }
}

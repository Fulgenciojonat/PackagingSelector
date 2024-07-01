<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Service\PackagingService;
use Illuminate\Http\Request;

class PackagingSelectorController
{
    private $packagingService;

    public function __construct(PackagingService $packagingService)
    {
        $this->packagingService = $packagingService;
    }

    public function showForm()
    {
        return view('product-packaging-selector.input-form');
    }

    public function processProducts(Request $request)
    {
        try {

            $products = [];
            for ($i = 1; $i <= 10; $i++) {
                $length = (int) $request->input("product{$i}_length", 0);
                $width = (int) $request->input("product{$i}_width", 0);
                $height = (int) $request->input("product{$i}_height", 0);
                $weight = (int) $request->input("product{$i}_weight", 0);
                $quantity = (int) $request->input("product{$i}_quantity", 0);

                // Only create a product if at least one field is filled out
                if ($length !== 0 || $width !== 0 || $height !== 0 || $weight !== 0 || $quantity !== 1) {
                    $products[] = new Product($length, $width, $height, $weight, $quantity);
                }
            }

            $result = $this->packagingService->selectPackaging($products);

            return view('product-packaging-selector.result', compact('result'));

        } catch(\Exception $exception) {
            $errorMessage = $exception->getMessage();
            return view('product-packaging-selector.input-form', compact('errorMessage'));
        }
    }
}

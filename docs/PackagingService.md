# **PackagingService Class**

The PackagingService class is responsible for selecting appropriate packaging (boxes) for a given set of products. It includes methods to load available boxes, determine the best box for packaging products, and handle various packaging scenarios.

**Namespace**

`namespace App\Service;`

**Dependencies**

`use App\Models\Box;
use App\Models\Product;
use Exception;`

Properties

`private array $boxes`
Holds an array of Box objects representing available boxes for packaging.
Initialized in the constructor using the loadBoxes method.

Constructor

`__construct()`

Initializes the boxes property by calling the loadBoxes method.

**Methods**

`private function loadBoxes(): array`

Loads box configurations and creates Box objects.
Sorts the boxes by volume in ascending order.

Returns

array: An array of sorted Box objects.

`public function selectPackaging(array $products): array`

* Selects appropriate boxes for packaging the given products.
* Flattens products to account for quantities.
* Finds the smallest suitable box for each set of products and handles packaging.
* Parameters
array $products: An array of Product objects to be packaged.

Returns

array<int, array{box: Box, products: Product[]}>: An array where each element contains a Box object and an array of Product objects that fit into that box.

Throws
Exception: If a product cannot fit into any box.

`private function arrayDiffProducts(array $array1, array $array2): array`

* Computes the difference between two arrays of products.

Parameters

* array $array1: The first array of products.
* array $array2: The second array of products to be removed from the first array.

Returns

array: The resulting array after removing products in $array2 from $array1.

`private function flattenProducts(array $products): array`
Flattens an array of products to account for quantities, creating multiple instances of the same product.
Parameters

array $products: An array of Product objects, potentially with quantities greater than 1.

Returns
array: A flattened array of Product objects.

`private function findSmallestSuitableBox(array $products): ?Box`
Finds the smallest box that can accommodate the given products based on volume, weight, and dimensions.

Parameters

array $products: An array of Product objects to be packaged.

Returns

?Box: The smallest suitable Box object, or null if no suitable box is found.

`private function canFitInBox(float $totalVolume, float $totalWeight, array $maxDimensions, Box $box): bool`

Checks if a set of products can fit into a given box based on total volume, total weight, and maximum dimensions.

Parameters

* float $totalVolume: The total volume of the products.
* float $totalWeight: The total weight of the products.
* array $maxDimensions: The maximum dimensions of the products (length, width, height).
* Box $box: The box to check.

Returns

bool: true if the products can fit into the box, false otherwise.

`private function calculateTotalVolume(array $products): float`

Calculates the total volume of an array of products.

Parameters

array $products: An array of Product objects.

Returns

float: The total volume of the products.

`private function calculateTotalWeight(array $products): float`

Calculates the total weight of an array of products.

Parameters

array $products: An array of Product objects.

Returns

float: The total weight of the products.

`private function getMaxDimensions(array $products): array`

Determines the maximum dimensions (length, width, height) of an array of products.

Parameters

array $products: An array of Product objects.

Returns

array<string, float>: An associative array containing the maximum length, width, and height of the products.

`private function getLargestProduct(array $products): Product`

Finds the product with the largest volume, or the greatest weight in case of a tie in volume.

Parameters

array $products: An array of Product objects.

Returns

Product: The product with the largest volume or weight.

`private function packProducts(Box $box, array $products): array`

Packs products into a given box, ensuring that they fit within the box's volume and weight limits.

Parameters
* Box $box: The box to pack products into.
* array $products: An array of Product objects to be packed.

Returns

array: An array of Product objects that have been packed into the box.

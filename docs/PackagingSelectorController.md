# **PackagingSelectorController Class**

The **PackagingSelectorController class** handles HTTP requests related to the product packaging selection process. It includes methods for displaying a form for product input and processing the input to select appropriate packaging.


**Namespace**

`namespace App\Http\Controllers;`

**Dependencies**

`use App\Models\Product;
use App\Service\PackagingService;
use Illuminate\Http\Request;`

**Properties**
private $packagingService
Holds an instance of the PackagingService class.

**Constructor**
__construct(PackagingService $packagingService)
Initializes the packagingService property with an instance of PackagingService.

**Methods**

`public function showForm()`
Displays the input form for product packaging selection.
Returns
A view of the input form located at product-packaging-selector.input-form.

`public function processProducts(Request $request)`
Processes the input from the product packaging selection form.
Creates Product objects based on the input data.
Calls the selectPackaging method of the PackagingService to determine the appropriate packaging.

**Parameters**
`Request $request:` The HTTP request containing product input data.
Returns
A view of the result located at product-packaging-selector.result, with the packaging selection result passed to it.
Example
Here’s an example of how you might use the PackagingSelectorController in a Laravel application:

**Routes (web.php)**

`use App\Http\Controllers\PackagingSelectorController;`

`Route::get('/packaging-selector', [PackagingSelectorController::class, 'showForm']);
Route::post('/packaging-selector', [PackagingSelectorController::class, 'processProducts']);`

**Views**
resources/views/product-packaging-selector/input-form.blade.php
resources/views/product-packaging-selector/result.blade.php
These views should be created to display the input form and the results of the packaging selection process.

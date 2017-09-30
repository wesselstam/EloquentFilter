EloquentFilter
======

>  EloquentFilter adds new functionalities to your Laravel Eloquent model to make filtering data easy.

## Installing EloquentFilter
You need to use Composer to install EloquentFilter into your project:
```
composer require wstam/eloquentfilter
```
## Configuring (Laravel)

Now you have to include `EloquentFilterServiceProvider` in your `config/app.php`:

```php
'providers' => [
    /*
     * Package Service Providers...
     */
    WStam\EloquentFilter\EloquentFilterServiceProvider::class,
]
```

Now we need to publish the default blade views by running the following Artisan command in your terminal:

```
php artisan vendor:publish --provider="WStam\EloquentFilter\EloquentFilterServiceProvider"
```

Now you have `container.blade.php` and `filter.blade.php` in your vendor/eloquentfilter view folder. You can change the the template of the filter container and the filter itself to make it fit to your own look and feel.

## How to use EloquentFilter
For an example, you want to add filtering to the Product model. Add the filtering trait to your model like this example:
```php
<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use WStam\EloquentFilter\EloquentFilterable;
 
class Product extends Model
{
    use EloquentFilterable;
}
```

Now you can specify filters to your Query Builder object:

```php
/**
 * Show all the products
 *
 * @return \Illuminate\Http\Response
 */
public function index()
{
    $products = Product::query()->orderBy('title', 'ASC');
 
    // addFilter($column, $label = null, $type = 'text', $default = null, $comparison = '=')
 
    $products->addFilter('title', 'Title', 'text');
    $products->addFilter('external_supplier', 'External supplier', 'boolean');
    
    // Use filterCollection instead of get() to implement the "renderFilter" method into the collection
    $productCollection = $products->filterCollection();
 
    return view('product.index', ['products' => $productCollection]);
}
```

Now you can render the filters inside your blade template:

```php
<!-- This renders the filters. You can change the filter views at vendor/eloquentfilter -->
{!! $products->renderFilters() !!}
 
<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>External supplier</th>
            </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
            <tr>
                <td>
                    <a href="{{ route('product_edit', $product->id) }}">{{$product->title}}</a>
                </td>
                <td>
                    @if($product->external_supplier == 1)
                        Yes
                    @else
                        No
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
```

## Contributing

Do have good ideas about expanding/enhancing this library? Feel free to contribute and send a pull request!


## License

EloquentFilter is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

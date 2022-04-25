<h2 align="center" style="font-size: 27px">
    Laravel Repository
</h2>

<p align="center">
    <img width="470" src="https://borzoyi.ir//static/github/laravel-repository/repository-design-pattern-in-laravel.webp" alt="Supernova image" />
</p>

<h3 align="center">Use Repository Pattern in Laravel app</h3>

-----------------------

## Installation: :arrow_down:
```bash
composer require mohamadtsn/laravel-repository
```

## configuration: :gear:
__Publish config file__
```bash
php artisan vendor:publish --tag=repository-config --force
```

 -----------------
### Do in Laravel 8:
Put this in `App\Http\Controllers\Controller.php`
```php
use Mohamadtsn\Repository\Traits\Repository; // use Repository trait

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, Repository// use trait in Controller class;
    // other class methods
}
```
**Enjoy it** :wave:
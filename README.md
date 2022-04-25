<h2 align="center" style="font-size: 27px">
    Laravel Supernova
</h2>

<p align="center">
    <img width="470" src="https://i.pinimg.com/originals/bd/6d/5c/bd6d5c4be48278fb961771115057b17a.jpg" alt="Supernova image" />
</p>

<h3 align="center">Give a professional and powerful management panel as your Laravel App gift. :gift:</h3>

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
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
composer require mohamadtsn/laravel-supernova
```

## configuration: :gear:
__Publish config file__
```bash
php artisan vendor:publish --tag=supernova-config --force
```

Change locale to `fa` in `config/app.php`
```php
'locale' => 'fa',
```

:electric_plug: (For Laravel <=5.4) Next, you must add the service provider to `config/app.php` :electric_plug:
```php
'providers' => [
    // for laravel 5.4 and below
    App\Providers\MetronicServiceProvider::class,
];
```

Add this to your `Aliases` in `config/app.php`
```php
'aliases' => [
    // other aliases
    'Metronic' => App\Classes\Theme\Metronic::class,
    'Menu' => App\Classes\Theme\Menu::class,
],
```
 -----------------
### Do in Laravel 8:
Put this in `App\Models\User.php`
```php
use Spatie\Permission\Traits\HasRoles; // use permission trait

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles // use trait in User class;
    // other class methods
}
```
-----------------
Add `level` to `fillable` fields in `App\Models\User.php`.
```php
protected $fillable = [
    'level',
];
```

Change `composer.json` autoload section and add `helpers.php` to `files` section like below:
```json
{
  "autoload": {
    "psr-4": {
      "...": "PSR-4 values"
    },
    "files": [
      "app/Tools/helpers.php"
    ]
  }
}
```


Add these seeders call in `Database\Seeders\DatabaseSeeder.php` in `run()` method:
```php
class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Other seeders call
        // You add seeders
        $this->call(UserSeeder::class); // #1
        $this->call(PermissionSeeder::class); // #2
    }
}
```

Add these into `guards` section in `config/auth.php`:
```php
'guards' => [
    // other guard
    'admin' => [
        'driver' => 'session',
        'provider' => 'users',
    ],
],
```


Put these in `app/Http/Kernel.php` like below:
```php
use App\Http\Middleware\Panel\CheckPermission; // use Middleware class CheckPermission

class Kernel extends HttpKernel
{
    protected $routeMiddleware = [
        // other routeMiddleware
        'permission' => CheckPermission::class, // add CheckPermission::class on this section
    ];
}
```

Change these in `App/Http/Middleware/Authenticate.php` in `redirectTo` method like below:
```php
protected function redirectTo($request)
{
    if (! $request->expectsJson()) {
        return route('panel.login'); // change this section to `return route('panel.login')`
    }
}
```

add admin panel routes file `routes/admin.php` to `App/Providers/RouteServiceProvider.php` in `boot()` method
<p>
<span style="font-weight: bold;color: #ff5b5d">IMPORTANT!!</span> Be sure to add before `web.php`.
</p>
Look carefully:

```php
public function boot()
{
    $this->routes(function () {
        // other routes file
        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/admin.php')); // #1 add admin panel routes
        
        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/web.php')); // #2 web.php routes
    });
}
```

### Setup Schema:
1) Set database config connection in `.env` file
2) Migrate and seeding using the following commands:
```bash
php artisan migrate:fresh --seed        // "Associated with" Drop All Tables & Migrate and seeding
"Or"
php artisan migrate --seed              // "Without" Drop All Tables & Migrate and seeding
```

### re-generate composer autoload:
```bash
 composer dump-autoload
```

-----------------
## Usage
### Method #1  ====> Setup with virtual host
- Build a `virtual subdomain` with name `Management`
  <p style="font-weight: bold;color: #00b300">Example:</p>
  - origin domain => `shop.test`        // Main URL
  - subdomain domain => `management.shop.test`     // Admin Panel URL

- add **param** `Admin Panel URL` to `env` file with name `APP_MANAGEMENT_URL` like below:
  ```env
  APP_URL= http://shop.test
  APP_MANAGEMENT_URL= http://management.shop.test
  ```
- add **config** `Admin Panel URL` to `config/app.php` file with name `management_url` like below:
  ```php
  return [
      // other configs
      'management_url' => env('APP_MANAGEMENT_URL', 'http://management.shop.test'),
  ]
  ```
- Login to Panel `management.shop.test/login`
- Dashboard Panel `management.shop.test/`

### Method #2  ====> Setup without virtual host
1) publish basic routes:
  ```bash
  php artisan vendor:publish --tag=basic-routes --force
  ```
2) serve app with command:
```bash
php artisan serve
```
3) <span><span style="font-weight: bold;color: #00b300;font-size: 15px">Tip:</span> You have access to `Supernova Panel Routes` only with Prefix `panel`</span>
4) Go to `127.0.0.1:8000/panel/login`
-----------------
## Login to Panel
* Email: `admin@gmail.com`
* Password: `supernova@123`

**Enjoy it** :wave:
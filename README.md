# Install
### Trait
Add `HasReferrals` trait to User model.

```php
use Atin\LaravelReferrals\Traits\HasReferrals;

class User extends Authenticatable
{
    use HasReferrals;
```

### Register the Middleware
Ensure that your `HandleReferral` middleware is properly registered in the `app/Http/Kernel.php` file.
```php
protected $middleware = [
    …
    \Atin\LaravelReferrals\Middleware\HandleReferral::class, // Add your middleware here
];
```

### Run Migrations
```php
php artisan migrate
```

# Usage
Now users can get their referral link like this:
```php
{{ auth()->user()->getReferralLink() }}
```

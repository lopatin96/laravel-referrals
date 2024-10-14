# Install
### Trait
Add ```HasReferrals``` trait to User model.

```php
use Atin\LaravelReferrals\Traits\HasReferrals;

class User extends Authenticatable
{
    use HasReferrals;
```

### Validate, Save and Forget the referrer ID
Now, modify your create method to use this validation rule. You'll need to retrieve the referrer ID from cookies and pass it into the validator:
```php
namespace App\Actions\Fortify;

…

class CreateNewUser implements CreatesNewUsers
{
    public function create(array $input): User
    {
        return DB::transaction(function () use ($input) {
            $referrerId = request()->cookie('referrer_id');
            
            cookie()->queue(cookie()->forget('referrer_id'));
            
            return tap(User::forceCreate([
                …
                'referrer_id' => User::where('id', $referrerId)->exists() ? $referrerId : null,
            ]), function (User $user) {
                $this->createTeam($user);
            });
        });
```

### Register the Middleware
Ensure that your `HandleReferral` middleware is properly registered in the `app/Http/Kernel.php` file.
```php
protected $middlewareGroups = [
    'web' => [
        …
        \Atin\LaravelReferrals\Middleware\HandleReferral::class, // Add your middleware here
    ],
    …
];
```

# Usage
Now users can get their referral link like this:
```php
{{ auth()->user()->getReferralLink() }}
```
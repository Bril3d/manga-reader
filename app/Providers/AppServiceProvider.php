<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Opcodes\LogViewer\Facades\LogViewer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Support\Facades\Event;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        Gate::before(function ($user, $ability) {
            return $user->hasRole('super admin') ? true : null;
        });

        Event::listen(
            Registered::class,
            SendEmailVerificationNotification::class,
        );

        try {
            if (file_exists(storage_path('installed')) && \Illuminate\Support\Facades\Schema::hasTable('settings')) {
                config(['app.name' => settings()->get('name', 'Manga')]);
                config(['app.url' => settings()->get('url', 'http://localhost')]);
                config(['app.locale' => settings()->get('locale', 'en')]);
                config(['log-viewer.back_to_system_url' => settings()->get('url', 'http://localhost')]);

                config(['theme.active' => settings()->get('theme.active', 'default')]);

                config(['mail' => [
                    'driver' => settings()->get('mail.driver', 'smtp'),
                    'host' => settings()->get('mail.host', 'smtp.mailgun.org'),
                    'port' => settings()->get('mail.port', '587'),
                    'username' => settings()->get('mail.username'),
                    'password' => settings()->get('mail.password'),
                    'encryption' => settings()->get('mail.encryption'),
                    'from' => [
                        'address' => settings()->get('mail.address', 'test@localhost'),
                        'name' => settings()->get('name'),
                    ],
                ]]);

                LogViewer::auth(function ($request) {
                    if (!auth()->check()) {
                        return false;
                    }

                    return auth()->user()->can('view_logs');
                });
            }
        } catch (\Throwable $e) {
            // Ignore database errors during boot
        }
    }
}

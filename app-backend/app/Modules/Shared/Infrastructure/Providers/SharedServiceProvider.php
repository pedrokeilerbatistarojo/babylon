<?php

namespace App\Shared\Infrastructure\Providers;

use App\Shared\Contracts\EventBusInterface;
use App\Shared\Contracts\KeyPairGeneratorInterface;
use App\Shared\Contracts\NotificationInterface;
use App\Shared\Contracts\PaymentProcessorInterface;
use App\Shared\Infrastructure\Services\EventBus;
use App\Shared\Infrastructure\Services\KeyPairGenerator;
use App\Shared\Infrastructure\Services\MentaPaymentProcessor;
use App\Shared\Infrastructure\Services\TelegramNotification;
use Illuminate\Support\ServiceProvider;

class SharedServiceProvider extends ServiceProvider
{
    /**
     * All the container singletons that should be registered.
     *
     * @var array
     */
    public $singletons = [
        //Validators
        EventBusInterface::class => EventBus::class,
        KeyPairGeneratorInterface::class => KeyPairGenerator::class,
        PaymentProcessorInterface::class => MentaPaymentProcessor::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(PaymentProcessorInterface::class, function () {
            return new MentaPaymentProcessor;
        });

        $this->app->singleton(NotificationInterface::class, function () {
            $bot_token = config('modules.telegram.bot_logger');

            return new TelegramNotification($bot_token);
        });
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [
            //Services
            EventBus::class,
            KeyPairGenerator::class,
            MentaPaymentProcessor::class,
        ];
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void {}
}

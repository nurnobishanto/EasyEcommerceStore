<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
//        $subscription_last_check = getSetting('subscription_last_check')??'1997-01-01';
//        $exp_date = getSetting('subscription_expire_date')??'1997-01-01';
//        if (($subscription_last_check < date('Y-m-d',time())) || ($exp_date < date('Y-m-d',time())) ){
//            setSetting('subscription_last_check',date('Y-m-d',time()) );
//            coorHelper();
//        }
    }
}

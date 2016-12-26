<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator, Agent;
use App\Catalog;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('catalog', function($attribute, $value, $parameters, $validator) {
            $catalogs = Catalog::getCatalogsById($value);
            return !empty($catalogs);
        });
        Validator::replacer('catalog', function($message, $attribute, $rule, $parameters) {
            return str_replace([':name'], $parameters, $message);
        });
        Validator::extend('catalog_name', function($attribute, $value, $parameters, $validator) {
            $catalogs = Catalog::getCatalogsByName((!empty($parameters[0]) ? $parameters[0] : '').'.'.$value);
            return !empty($catalogs);
        });
        Validator::replacer('catalog_name', function($message, $attribute, $rule, $parameters) {
            return str_replace([':name'], $parameters, $message);
        });

        if (config('app.debug'))
        {
            switch (strtolower(Agent::browser())) {
                case 'chrome':
                    app('log')->getMonolog()->pushHandler(new \Monolog\Handler\ChromePHPHandler()); //chrome-php
                    break;
                case 'firefox':
                    app('log')->getMonolog()->pushHandler(new \Monolog\Handler\FirePHPHandler()); //firebug-php
                    break;
                default:
                    app('log')->getMonolog()->pushHandler(new \Monolog\Handler\BrowserConsoleHandler()); //console.log
                    break;
            }
        }
       //app('log')->getMonolog()->pushHandler(new \Monolog\Handler\PHPConsoleHandler()); //chrome-php-console
       //instead with DatabaseAuditor
       app(\OwenIt\Auditing\AuditorManager::class)->extend('database', function(){
            return new \App\Drivers\DatabaseAuditor();
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;
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

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Form::macro('error', function($field, $errors){
            if(count($errors->get($field)) > 0 || $errors->has($field))
            {
                echo '<span class="help-block">'. $errors->first($field) .'</span>';
            }
        });

        \Form::macro('FormGroup', function ($field = null, $errors = null){


            if(count($errors->get($field)) > 0 || $errors->has($field))
            {
                return '<div class="form-group has-error">';
            }

            return '<div class="form-group">';
        });

        \Form::macro('endFormGroup', function(){
            return '</div>';
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

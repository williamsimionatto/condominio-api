<?php

namespace App\Providers;

use App\Validator\CNPJValidator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider {
    public function register() {
        $this->app->register(RepositoryServiceProvider::class);
        $this->app->register(ValidatorServiceProvider::class);
    }

    public function boot() {
        Schema::defaultStringLength(191);
    }
}

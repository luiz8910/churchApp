<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;


class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Repositories\UserRepository::class, \App\Repositories\UserRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\StateRepository::class, \App\Repositories\StateRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PersonRepository::class, \App\Repositories\PersonRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RoleRepository::class, \App\Repositories\RoleRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\GroupRepository::class, \App\Repositories\GroupRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\EventRepository::class, \App\Repositories\EventRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\VisitorRepository::class, \App\Repositories\VisitorRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ChurchRepository::class, \App\Repositories\ChurchRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ResponsibleRepository::class, \App\Repositories\ResponsibleRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\FrequencyRepository::class, \App\Repositories\FrequencyRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RecentUsersRepository::class, \App\Repositories\RecentUsersRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RecentGroupsRepository::class, \App\Repositories\RecentGroupsRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RecentEventsRepository::class, \App\Repositories\RecentEventsRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RequiredFieldsRepository::class, \App\Repositories\RequiredFieldsRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RegisterModelsRepository::class, \App\Repositories\RegisterModelsRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\EventSubscribedListRepository::class, \App\Repositories\EventSubscribedListRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\UploadStatusRepository::class, \App\Repositories\UploadStatusRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\GeofenceRepository::class, \App\Repositories\GeofenceRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ImportRepository::class, \App\Repositories\ImportRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\FeedRepository::class, \App\Repositories\FeedRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ReportRepository::class, \App\Repositories\ReportRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SiteRepository::class, \App\Repositories\SiteRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ContactSiteRepository::class, \App\Repositories\ContactSiteRepositoryEloquent::class);
        //:end-bindings:
    }
}

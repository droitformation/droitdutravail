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
        view()->composer('*', 'App\Http\ViewComposers\CategorieComposer');
        view()->composer(['frontend.*','partials.navigation'], 'App\Http\ViewComposers\NewsletterComposer');
        
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerPageService();
        $this->registerPageWorkerService();
    }

    /**
     * Page
     */
    protected function registerPageService(){

        $this->app->singleton('App\Droit\Page\Repo\PageInterface', function()
        {
            return new \App\Droit\Page\Repo\PageEloquent(new \App\Droit\Page\Entities\Page);
        });
    }

    /**
     * Page worker
     */
    protected function registerPageWorkerService(){

        $this->app->singleton('App\Droit\Page\Worker\PageWorker', function()
        {
            return new \App\Droit\Page\Worker\PageWorker(
                \App::make('App\Droit\Page\Repo\PageInterface')
            );
        });
    }


}

<?php

namespace Cirote\Activos\ServiceProvider;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Cirote\Activos\Actions\Precios\ObtenerPreciosAction;

class ServiceProvider extends BaseServiceProvider
{
	public function register()
	{
		$this->register_migrations();

		$this->register_routes();

		$this->register_views();
	}

	public function boot()
	{
		$this->loadTranslationsFrom(__DIR__ . '/../Translations', 'activos');

		$this->bind_class();
	}

	private function bind_class()
	{
		$this->app->singleton(ObtenerPreciosAction::class, function ($app) 
		{
    		return new ObtenerPreciosAction();
		});
	}

	private function register_migrations()
	{
		$this->loadMigrationsFrom(__DIR__ . '/../Migrations');
	}

	private function register_routes()
	{
		$this->loadRoutesFrom(__DIR__ . '/../Routes/routes.php');
	}

	private function register_views()
	{
		$this->loadViewsFrom(__DIR__ . '/../Views', 'activos');
	}

}
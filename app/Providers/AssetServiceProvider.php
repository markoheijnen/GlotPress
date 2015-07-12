<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Stolz\Assets\Manager as Assets;

class AssetServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register() {
		Assets::add('global/plugins/jquery.min.js');
	}

}

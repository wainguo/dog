<?php namespace App\Providers;

use App\Models\Article\Article;
use App\Repositories\Backend\Article\ArticleRepositoryContract;
use App\Repositories\Backend\Article\EloquentArticleRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Backend\Slider\SliderRepositoryContract;
use App\Repositories\Backend\Slider\EloquentSliderRepository;

/**
 * Class HistoryServiceProvider
 * @package App\Providers
 */
class BackendServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(SliderRepositoryContract::class, EloquentSliderRepository::class);
		$this->app->bind(ArticleRepositoryContract::class, EloquentArticleRepository::class);
	}
}
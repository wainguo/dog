<?php

namespace App\Repositories\Backend\Article;
use App\Models\Article\Article;

/**
 * Interface ArticleRepositoryContract
 * @package app\Repositories\Article
 */
interface ArticleRepositoryContract
{

    public function getCount();
	/**
     * @return mixed
     */
    public function getForDataTable();

    /**
     * @param  $input
     * @return mixed
     */
    public function create($input);

    /**
     * @param  Article $article
     * @param  $input
     * @return mixed
     */
    public function update(Article $article, $input);

    /**
     * @param  Article $article
     * @return mixed
     */
    public function destroy(Article $article);
}
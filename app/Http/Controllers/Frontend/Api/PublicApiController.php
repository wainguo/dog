<?php
/**
 * Created by PhpStorm.
 * User: wainguo
 * Date: 16/7/3
 * Time: 下午8:31
 */

namespace App\Http\Controllers\Frontend\Api;


use App\Http\Controllers\Controller;

use App\Http\Requests;
use App\Models\Article\Article;
use App\Models\Article\Category;
use App\Models\Article\Comment;
use Illuminate\Http\Request;


class PublicApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function getMoreArticles(Request $request)
    {
        $conditions = array(
        );
        $channelId = $request->input('channel');
        if(isset($channelId) && $channelId > 0){
            array_push($conditions, ['channel_id', $channelId]);
        }

        $articles = Article::status('publish')
            ->where($conditions)
            ->with('user', 'tags', 'categories', 'mall', 'channel')
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);
        return $this->jtmdsSuccess($articles);
    }

//  查看文章
    public function getArticle($id)
    {
        $article = Article::with('user', 'tags', 'categories')->find($id);
        return $this->jtmdsSuccess($article);
    }

    public function getComments(Request $request)
    {
        $articleId = $request->input('article_id');
        if(empty($articleId)){
            return $this->jtmdsError('缺少参数');
        }
        $comments = Comment::root()
            ->with('replies')
            ->where('article_id', $articleId)
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return $this->jtmdsSuccess($comments);
    }

    public function getCategories()
    {
        $categories = Category::root()
            ->with('children', 'children.children')
            ->orderBy('category_order', 'asc')
            ->get();
        return $this->jtmdsSuccess($categories);
    }

    public function getProperties(Request $request)
    {
        $articleId = $request->input('article_id');
        if(empty($articleId)){
            return;
        }
        $article = Article::find($articleId);
        if(empty($article)){
            return;
        }

        $properties = array(
            'tags'=> $article->tags,
            'categories' => $article->categories
        );
        return $this->jtmdsSuccess($properties);
    }
}
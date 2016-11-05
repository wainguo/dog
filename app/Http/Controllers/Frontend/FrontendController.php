<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Article\Article;
use App\Models\Article\Channel;
use App\Models\Slider;
use App\Models\Wisdom;
use Illuminate\Support\Facades\Auth;

/**
 * Class FrontendController
 * @package App\Http\Controllers
 */
class FrontendController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // 菜根谭
        $rand = rand(1, Wisdom::nice()->count());
        $wisdom = Wisdom::nice()->find($rand);
        if(!empty($wisdom)){
            session(['wisdom' => $wisdom->content]);
        }

        //slide show 6 items
//        $homeslideArticles = Article::block('homeslide')->take(6)->get();
        $homeslideArticles = Slider::active()->position('slideshow')->take(6)->get();
        $showcaseArticles = Slider::active()->position('showcase')->take(3)->get();

        $featuredArticles = Article::block('featured')->take(6)->get();
//        $showcaseArticles = Article::block('showcase')->take(3)->get();

        //first page articles
        $articles = Article::status('publish')
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        $user = Auth::user();

        return view('frontend.index', [
            'featuredArticles' => $featuredArticles,
            'homeslideArticles' => $homeslideArticles,
            'showcaseArticles' => $showcaseArticles,
            'articles' => $articles,
            'user' => $user
        ]);
    }

    //  查看文章
    public function article($id)
    {
        $article = Article::find($id);
        if(empty($article)){
            return view('errors.errorpage', ['error_message' => '您要查看的文章没有找到!']);
        }
        $article->view_count++;
        $article->save();

        $relatedArticles = Article::ofChannel($article->channel_id)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('frontend.article.detail', [
            'article' => $article,
            'relatedArticles' => $relatedArticles
        ]);
    }

    //channel youhui
    public function youhui()
    {
        return $this->gotoChannelOfName('youhui');
    }

    //channel haitao
    public function haitao()
    {
        return $this->gotoChannelOfName('haitao');
    }

    //channel coupon
    public function coupon()
    {
        return $this->gotoChannelOfName('coupon');
    }

    //channel news
    public function news()
    {
        return $this->gotoChannelOfName('news');
    }

    //channel yuanchuang
    public function post()
    {
        return $this->gotoChannelOfName('post');
    }

    private function gotoChannelOfName($channelName)
    {
        $channel = Channel::ofName($channelName)->first();

        $articles = array();
        if(!empty($channel)){
            $articles = Article::ofChannel($channel->id)
                ->status('publish')
                ->orderBy('created_at', 'desc')
                ->paginate($this->perPage);
        }

        $popularArticles = Article::status('publish')
            ->orderBy('view_count', 'desc')
            ->take(10)
            ->get();

        return view('frontend.channel', [
            'channel' => $channel,
            'articles' => $articles,
            'popularArticles' => $popularArticles
        ]);
    }

    //    amazon aStore
    public function astore()
    {
        return view('frontend.astore');
    }

    public function search()
    {
        return view('frontend.static.search');
    }

    //about
    public function about()
    {
        return view('frontend.static.about');
    }

    //terms
    public function terms()
    {
        return view('frontend.static.terms');
    }

    public function contact()
    {
        return view('frontend.static.contact');
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: wainguo
 * Date: 16/7/3
 * Time: 下午8:31
 */

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Access\User\User;
use App\Models\Article\Article;
use App\Models\Article\Category;
use App\Models\Article\Channel;
use App\Models\Article\Comment;
use App\Models\Article\Mall;
use App\Models\Article\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use PHPHtmlParser\Dom;


class ArticleController extends Controller
{
    protected $allowedExtensions = ["png", "jpg", "jpeg", "gif"];
    protected $imageUploadPath = '';
    protected $imageUploadUrl = '';

    public function __construct()
    {
        $this->middleware('auth');

        $this->imageUploadPath = storage_path('app/public');
        $this->imageUploadUrl = url(Storage::url(''));
    }

//  添加分类目录
//    public function postAddCategory(Request $request)
//    {
//        $categoryName = $request->input('category_name');
//        $categoryParent = $request->input('category_parent', 0);
//
//        $category = Category::where('category_name', $categoryName)->first();
//        if(empty($category)){
//            $category = Category::create(['category_name'=>$categoryName, 'category_parent'=>$categoryParent]);
//        }
//        return redirect()->back()->withInput();
//    }

    public function show($id)
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

    public function edit($id = null)
    {
        if(!empty($id)) {
            $article = Article::find($id);
            if($article->user_id != Auth::user()->id){
                return view('errors.errorpage', ['error_message' => '您没有权限编辑该文章']);
            }
        }
        if(empty($article)) {
            $article = new Article();
        }

        $channels = Channel::all();
        $categories = Category::root()->get();
        $tags = Tag::all();
        $malls = Mall::all();

//      异常处理,如果没有怎么?
        return view('frontend.article.edit', [
            'article' => $article,
            'channels' => $channels,
            'categories' => $categories,
            'tags' => $tags,
            'malls' => $malls
        ]);
    }

    public function baoliao($id = null)
    {
        if(!empty($id)) {
            $article = Article::find($id);
            if($article->user_id != Auth::user()->id){
                return view('errors.errorpage', ['error_message' => '您没有权限编辑该文章']);
            }
        }
        if(empty($article)) {
            $article = new Article();
        }

        $channels = Channel::all();
        $categories = Category::root()->get();
        $tags = Tag::all();
        $malls = Mall::all();

//      异常处理,如果没有怎么?
        return view('frontend.article.baoliao', [
            'article' => $article,
            'channels' => $channels,
            'categories' => $categories,
            'tags' => $tags,
            'malls' => $malls
        ]);
    }

    //  编辑文章的保存
    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'url' => 'required',
            'content' => 'required',
            'channel_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = Auth::user();

        $articleId = $request->article_id;
        if(!empty($articleId)){
            $article = Article::find($articleId);
        } else {
            $article = new Article();
            $article->user_id = $user->id;
            $article->user_name = $user->name;
        }

        if(empty($article)) {
            return view('errors.errorpage', ['error_message' => '没有找到对应的文章']);
        }

        if($article->user_id != $user->id) {
            return view('errors.errorpage', ['error_message' => '您没有权限编辑该文章']);
        }

        $article->title = $request->input('title');
        $article->channel_id = $request->input('channel_id');
        $article->mall_id = $request->input('mall_id', 0);
        $article->type = $request->input('type', 'product');
        $article->content = $request->input('content');
        $article->description = $request->input('description', '');
        $article->url = $request->input('url', '');
        $article->excerpt = str_limit(strip_tags($article->content), 250);
        $result = $this->getAndSaveImageFromContent($article->content, $this->imageUploadPath, $this->imageUploadUrl);
        $article->content = $result['content'];
        if(!$article->cover && count($result['image_urls'])>0){
            $article->cover = $result['image_urls'][0];
        }
        if($article->save()) {
            $categories = $request->input('categories');
            if(!empty($categories)){
                foreach($categories as $category){
                    $article->categories()->attach($category);
                }
            }
            $tagIds = $request->input('tag_ids');
            if(!empty($tagIds)){
                foreach($tagIds as $tagId){
                    $article->tags()->attach($tagId);
                }
            }
            return view('frontend.article.success', [
                'article_id' => $article->id
            ]);
        }
        else {
            return redirect()->back()->withInput();
        }
    }

    // 保存评论
    public function postSaveComment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'article_id' => 'required',
            'content' => 'required|min:8',
        ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput()
                ->with('toast_message', '评论失败了,请检查输入!');
        }

        //评论所回复的评论id
        $parentId = $request->input('parent_id');
        if(empty($parentId)) {
            $parentId = 0;
        }
        //所评论的文章的id
        $articleId = $request->input('article_id');

        $user = Auth::user();
        $comment = new Comment();
        $comment->parent_id = $parentId;
        $comment->article_id = $articleId;
        $comment->content = $request->input('content');
        $comment->user_id = $user->id;
        $comment->user_name = $user->name;
        $comment->user_ip = $request->ip();

        if($comment->save()){
            return redirect()->back()->with('toast_message', '评论成功了!');
        }
        else {
            return redirect()->back()->with('toast_message', '评论失败了,请重试!');
        }
    }

    /**
     * deal with ckeditor image upload.
     *
     * @return \Illuminate\Http\Response
     */
    public function postUploadImage(Request $request)
    {
        $user = Auth::user();

        $callback = $request->input('CKEditorFuncNum');

        if ($request->hasFile('upload') && $request->file('upload')->isValid()){
            $file = $request->file('upload');
//            $allowed_extensions = ["png", "jpg", "jpeg", "gif"]; //允许的图片后缀
            if ($file->getClientOriginalExtension() && !in_array($file->getClientOriginalExtension(), $this->allowedExtensions)) {
                $errorMessage = '图片后缀只支持png,jpg,gif,请检查！';
                $url = '';
            }
            else {
                $fileName = uniqid('pic').'.'.$file->guessExtension();
//                $storagePath = storage_path('app/public');

                $fullImagePath = $this->imageUploadPath.DIRECTORY_SEPARATOR.$fileName;

                Image::make($file)->resize(720, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($fullImagePath, 80);
//            ->resize(320,240)->save($imageThumbnail)

//                $path = $file->move($this->imageUploadPath, $fileName);

//            response()->json(["error" => "0", "msg" => "上传图片成功"]);
//            Storage::put(
//                'u'.$user->id.'/'.$imageName,
//                file_get_contents($request->file('avatar')->getRealPath())
//            );

                $url = url(Storage::url($fileName));
                $errorMessage = '';
            }
        }
        else {
            $url = '';
            $errorMessage = '上传文件非法';
        }

        $output = "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($callback, '$url', '$errorMessage');</script>";
        return response($output);
    }

    public function getAndSaveImageFromContent($content, $destPath, $baseUrl)
    {
        $imageList = $this->getImageByReg($content);
        $localBaseUrl = url('');
        foreach ($imageList as $key => $val) {
            if ( strpos($val['src'], $localBaseUrl) !== false ) {
                $arr = explode('/', $val['src']);
                $name = array_pop($arr);
                $imageList[$key]['src'] = $name;
                continue;
            }
            $arr = explode('.', $val['src']);
            $ext = array_pop($arr);
            if (!$ext || !in_array($ext, $this->allowedExtensions)) {
                $ext = 'jpg';
            }
            $name = uniqid().'.'.$ext;
            $imageList[$key]['src'] = $name;

            $file = file_get_contents($val['src']);
            file_put_contents($destPath .'/'. $name, $file);
        }

        $newImgInfo = $this->replaceImageUrl($imageList, $baseUrl);
        $newImgTags = $newImgInfo['newImgTags'];
        $newImgUrls = $newImgInfo['newImgUrls'];

        $patterns = array('/<img\s.*?>/');
        $callback = function( $matches ) use ( &$newImgTags ) {
            $matches[0] = array_shift($newImgTags);
            return $matches[0];
        };

        $res = array();
        $res['content'] = preg_replace_callback($patterns, $callback, $content);
        $res['image_urls'] = $newImgUrls;

        return $res;
    }

    private function getImageByReg($str)
    {
        $imageList = array();
        $c1 = preg_match_all('/<img\s.*?>/', $str, $m1);
        for($i = 0; $i < $c1; $i++) {
            $c2 = preg_match_all('/(\w+)\s*=\s*(?:(?:(["\'])(.*?)(?=\2))|([^\/\s]*))/', $m1[0][$i], $m2);
            for($j = 0; $j < $c2; $j++) {
                $imageList[$i][$m2[1][$j]] = !empty($m2[4][$j]) ? $m2[4][$j] : $m2[3][$j];
            }
        }

        return $imageList;
    }
    // baseUrl with postfix '/'
    private function replaceImageUrl($imageList, $baseUrl)
    {
        $newImgTags = array();
        $newImgUrls = array();

        foreach ($imageList as $key => $val) {
            $imgTag = '<img ';
            foreach ($val as $attr => $v) {
                if ($attr === 'src') {
                    $imgTag .= $attr . '="' . $baseUrl .'/'. $v . '" ';
                    $newImgUrls[] = $baseUrl .'/' . $v;
                } else {
                    $imgTag .= $attr . '="' . $v . '" ';
                }
            }
            $imgTag .= ' >';

            $newImgTags[$key] = $imgTag;
        }

        return array('newImgTags' => $newImgTags, 'newImgUrls' => $newImgUrls);
    }

}
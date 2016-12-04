<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Models\Article\Article;
use App\Models\Article\Category;
use App\Models\Article\Channel;
use App\Models\Article\Mall;
use App\Models\Article\Tag;
use App\Repositories\Backend\Article\ArticleRepositoryContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Yajra\Datatables\Facades\Datatables;

/**
 * Class ArticleController
 * @package App\Http\Controllers\Backend
 */
class ArticleController extends Controller
{
    protected $articles;

    public function __construct(ArticleRepositoryContract $articles)
    {
        $this->articles = $articles;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.article.index');
    }

    public function get()
    {
        return Datatables::of($this->articles->getForDataTable())
            ->addColumn('actions', function($article) {
                return '<a href="' . route('admin.article.edit', $article) . '" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="' . trans('buttons.general.crud.edit') . '"></i></a> '
                        .'<a href="' . route('admin.article.destroy', $article) . '" class="btn btn-xs btn-danger" data-method="delete"><i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="' . trans('buttons.general.crud.delete') . '"></i></a>';
            })
            ->make(true);
    }

    public function create()
    {
        $channels = Channel::all();
        $categories = Category::root()->get();
        $tags = Tag::all();
        $malls = Mall::all();

//        $article = new Article();
        return view('backend.article.create', [
//            'article' => $article,
            'channels' => $channels,
            'categories' => $categories,
            'tags' => $tags,
            'malls' => $malls
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'url' => 'required',
            'content' => 'required',
//            'channel_id' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }

        $this->articles->create($request->all());
        return redirect()->route('admin.article.index')->withFlashSuccess(trans('alerts.backend.article.created'));
    }

    public function edit(Article $article, Request $request)
    {
        $channels = Channel::all();
        return view('backend.article.edit', [
            'channels' => $channels,
        ])
        ->withArticle($article);
    }

    public function update(Article $article, Request $request)
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

        $this->articles->update($article, $request->all());
        return redirect()->route('admin.article.index')->withFlashSuccess(trans('alerts.backend.article.updated'));
    }

    public function destroy(Article $article, Request $request)
    {
        $this->articles->destroy($article);
        return redirect()->route('admin.article.index')->withFlashSuccess(trans('alerts.backend.article.deleted'));
    }


    /**
     * deal with ckeditor image upload.
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadCkeditorImage(Request $request)
    {
        $user = access()->user();

        $callback = $request->input('CKEditorFuncNum');

        if ($request->hasFile('upload') && $request->file('upload')->isValid()){
            $file = $request->file('upload');
            $allowedExtensions = ["png", "jpg", "jpeg", "gif"]; //允许的图片后缀
            if ($file->getClientOriginalExtension() && !in_array($file->getClientOriginalExtension(), $allowedExtensions)) {
                $errorMessage = '图片后缀只支持png,jpg,gif,请检查！';
                $url = '';
            }
            else {
                $fileName = uniqid('pic').'.'.$file->guessExtension();
//                $storagePath = storage_path('app/public');

//                $fullImagePath = $this->imageUploadPath.DIRECTORY_SEPARATOR.$fileName;
                $fullImagePath = upload_path().DIRECTORY_SEPARATOR.$fileName;

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
}
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

use App\Models\Article\Category;
use App\Models\Article\Tag;
use Illuminate\Http\Request;


class AuthRequiredApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //创建分类目录
    public function postAddCategory(Request $request)
    {
        $categoryName = $request->input('category_name');
        $categoryParent = $request->input('category_parent', 0);

        $category = Category::where('category_name', $categoryName)->first();
        if(!empty($category)){
            return $this->jtmdsError('这个分类已经存在了');
        }

        $category = new Category();
        $category->category_name = $categoryName;
        $category->category_parent = $categoryParent;

        if($category->save()){
            $categories = Category::root()
                ->with('children', 'children.children')
                ->orderBy('category_order', 'asc')
                ->get();
            return $this->jtmdsSuccess($categories);
        }
    }

    public function postAddTags(Request $request)
    {
        $addedTags = [];
        $tagNamesStr = $request->input('tag_names');
        if(empty($tagNamesStr)){
            return $this->jtmdsError('请输入标签名');
        }
        $tagNames = explode(',', $tagNamesStr);
        foreach($tagNames as $tagName){
            $tag = Tag::where('tag_name', $tagName)->first();
            if(empty($tag)){
                $tag = Tag::create(['tag_name' => $tagName]);
            }
            array_push($addedTags, $tag);
        }

        return $this->jtmdsSuccess($addedTags);
    }
}
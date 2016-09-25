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

use App\Models\Article\Category;
use App\Models\Wisdom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use PHPHtmlParser\Dom;


class JtmdsToolController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getTest()
    {


        $file = storage_path('temp').DIRECTORY_SEPARATOR.'a.txt';  // 含路径文件名
        $txt = file_get_contents($file); // 读取文件全部内容
        $arr = explode(PHP_EOL, $txt); // 将文件内容以换行符分割成数组
        $max = 0;
        for($i=0; $i<count($arr); $i++){
            $str = trim($arr[$i]);
            $len = strlen($str);
            if($len > $max) $max = $len;
            if($len > 12){
                if(preg_match("/［/", $str)){
                    echo $str.": ".$len."<br>";
                    Wisdom::create(['content'=>$str, 'grade' => 2]);
                    continue;
                }

                if($len <300){
                    Wisdom::create(['content'=>$str]);
                }
                else {
                    Wisdom::create(['content'=>$str, 'grade' => 1]);
                }
            }
        }

        echo $max;
    }

    public function getCat()
    {
        $file = storage_path('temp').DIRECTORY_SEPARATOR.'cat.html';  // 含路径文件名
        $dom = new Dom();
        $dom->loadFromFile($file);
//        $dom->loadFromUrl('http://item.jd.com/2260201.html');
//        $a = $dom->find('#itemInfo #name h1');
//        $a = $dom->find('div#name h1');
        $topLis = $dom->getElementsByClass("category_box_select li");
//        $a = $dom->find('category_box_select h1');
        print_r(count($topLis));
        foreach ($topLis as $topLi) {
            $top = $topLi->find('.top_category_li');
            $data = $top->getAttribute('data');
            $text = $top->text;
            echo "$data -- $text <br>";

            $rootCategory = new Category();
            $rootCategory->parent_id = 0;
            $rootCategory->category_name = $text;
            $rootCategory->save();

            $secondLis = $topLi->find('li');
            foreach ($secondLis as $secondLi) {
                $second = $secondLi->find('.n2_category_li');
                $data = $second->getAttribute('data');
                $dataTop = $second->getAttribute('data_top');
                $text = $second->text;
                echo "&nbsp;&nbsp;$dataTop -- $data -- $text <br>";

                $category = new Category();
                $category->parent_id = $rootCategory->id;
                $category->category_name = $text;
                $category->save();

                $sub = $secondLi->find('.sub_tags_box');
                if(count($sub)<=0) continue;
                $thirdLis = $sub->find('a');
                if(count($thirdLis)<=0) continue;
                foreach ($thirdLis as $thirdLi) {
                    print_r("&nbsp;&nbsp;&nbsp;&nbsp;".$thirdLi->getAttribute('data_top').' -- '.$thirdLi->getAttribute('data').' -- '.$thirdLi->text."<br>\n");

                    $childCategory = new Category();
                    $childCategory->parent_id = $category->id;
                    $childCategory->category_name = $thirdLi->text;
                    $childCategory->save();
                }
            }
        }
    }
}
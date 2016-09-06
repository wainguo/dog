<?php
/**
 * Created by PhpStorm.
 * User: wainguo
 * Date: 16/7/3
 * Time: 下午8:31
 */

namespace App\Http\Controllers;


use App\Channel;
use App\Comments;
use App\Mall;
use App\Tag;
use App\User;
use App\Article;
use App\Category;
use App\Http\Requests;

use App\Wisdom;
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
        $a = $dom->find('div#name h1');
        print_r($a->text);
    }
}
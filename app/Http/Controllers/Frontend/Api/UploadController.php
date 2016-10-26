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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UploadController extends Controller
{
    // 上传文件临时保存目录
    protected $tempUploadPath = '';

    public function __construct()
    {
        $this->middleware('auth');
        $this->tempUploadPath = storage_path('app/public/temp');
    }

    public function postImage(Request $request) {
        if ($request->hasFile('file') && $request->file('file')->isValid()){
            $file = $request->file('file');

            //允许的图片后缀
            $allowedExtensions = ["png", "jpg", "jpeg", "gif"];
            if ($file->getClientOriginalExtension() && !in_array($file->getClientOriginalExtension(), $allowedExtensions)) {
                $errorMessage = '图片后缀只支持png,jpg,jpeg,gif,请检查！';
                return $this->jtmdsError($errorMessage);
            }
            else {
                $fileName = uniqid().'.'.$file->guessExtension();
                $storagePath = storage_path('app/public');

                $fullImagePath = $this->tempUploadPath.DIRECTORY_SEPARATOR.$fileName;
//                $path = $file->move($this->tempUploadPath, $fileName);

                Image::make($request->file('file'))->resize(640, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($fullImagePath, 80);

                $url = Storage::url("temp/".$fileName);
                return $this->jtmdsSuccess(["imageUrl" => $url]);
            }
        }
        else {
            $errorMessage = '上传文件非法';
            return $this->jtmdsError($errorMessage);
        }
    }

    public function postSlider(Request $request) {
        if ($request->hasFile('file') && $request->file('file')->isValid()){
            $file = $request->file('file');

            //允许的图片后缀
            $allowedExtensions = ["png", "jpg", "jpeg", "gif"];
            if ($file->getClientOriginalExtension() && !in_array($file->getClientOriginalExtension(), $allowedExtensions)) {
                $errorMessage = '图片后缀只支持png,jpg,jpeg,gif,请检查！';
                return $this->jtmdsError($errorMessage);
            }
            else {
                $fileName = uniqid().'.'.$file->guessExtension();
                $storagePath = storage_path('app/public/slider');

                $fullImagePath = $storagePath.DIRECTORY_SEPARATOR.$fileName;
                $path = $file->move($this->tempUploadPath, $fileName);

                Image::make($path)->resize(640, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($fullImagePath, 80);

                $url = Storage::url("slider/".$fileName);
                return $this->jtmdsSuccess(["imageUrl" => $url]);
            }
        }
        else {
            $errorMessage = '上传文件非法';
            return $this->jtmdsError($errorMessage);
        }
    }
}
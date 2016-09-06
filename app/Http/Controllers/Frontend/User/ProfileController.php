<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\User\UpdateProfileRequest;
use App\Repositories\Frontend\Access\User\UserRepositoryContract;
use Illuminate\Support\Facades\Storage;

/**
 * Class ProfileController
 * @package App\Http\Controllers\Frontend
 */
class ProfileController extends Controller
{

    protected $allowedExtensions = ["png", "jpg", "jpeg", "gif"];
    protected $imageUploadPath = '';
    protected $imageUploadUrl = '';

    public function __construct()
    {
//        $this->middleware('auth');

        $this->imageUploadPath = storage_path('app/public/avatar');
        $this->imageUploadUrl = url(Storage::url('avatar'));
    }

    /**
     * @return mixed
     */
    public function edit()
    {
        return view('frontend.user.profile.edit')
            ->withUser(access()->user());
    }

    /**
     * @param  UserRepositoryContract         $user
     * @param  UpdateProfileRequest $request
     * @return mixed
     */
    public function update(UserRepositoryContract $user, UpdateProfileRequest $request)
    {
        $user->updateProfile(access()->id(), $request->all());
        return redirect()->route('frontend.user.dashboard')->withFlashSuccess(trans('strings.frontend.user.profile_updated'));
    }


    public function getUpdateAvatar()
    {
        $user = Auth::user();
        $avatar = url(Storage::url('avatar')).$user->id.".jpg";
        return view('user.avatar', [
            'avatar' => $avatar
        ]);
    }

    public function postUpdateAvatar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'source_image' => 'required',
            'container_width' => 'required',
            'x' => 'required',
            'y' => 'required',
            'w' => 'required',
            'h' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->with('toast_message', '更新失败了');
        }
        $containerWidth = $request->input('container_width');
        $sourceImage = $request->input('source_image');
        $x = $request->input('x');
        $y = $request->input('y');
        $w = $request->input('w');
        $h = $request->input('h');

        $user = Auth::user();
        $sourceImagePath = public_path().$sourceImage;
        $destImage = storage_path('app/public')."/avatar/".$user->id.".jpg";

        Image::make($sourceImagePath)->resize($containerWidth, null, function ($constraint) {
            $constraint->aspectRatio();
        })->crop($w, $h, $x, $y)->resize(200, 200)->save($destImage, 80);

        return view('user.profile', [
            'user' => $user
        ]);
    }
}
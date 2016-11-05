<?php

namespace App\Repositories\Backend\Slider;

use App\Models\Slider;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use App\Events\Backend\Access\Role\RoleCreated;
use App\Events\Backend\Access\Role\RoleDeleted;
use App\Events\Backend\Access\Role\RoleUpdated;

/**
 * Class EloquentSliderRepository
 */
class EloquentSliderRepository implements SliderRepositoryContract
{

    public function getCount() {
        return Slider::count();
    }

	/**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getForDataTable() {
        return Slider::all();
    }

    /**
     * @param  $input
     * @throws GeneralException
     * @return bool
     */
    public function create($input)
    {
//		if (Slider::where('name', $input['name'])->first()) {
//			throw new GeneralException(trans('exceptions.backend.access.roles.already_exists'));
//		}

		//See if the role has all access
//		$all = $input['associated-permissions'] == 'all' ? true : false;

//		if (! isset($input['permissions']))
//			$input['permissions'] = [];

		//This config is only required if all is false
//		if (! $all) {
//			//See if the role must contain a permission as per config
//			if (config('access.roles.role_must_contain_permission') && count($input['permissions']) == 0) {
//				throw new GeneralException(trans('exceptions.backend.access.roles.needs_permission'));
//			}
//		}

		DB::transaction(function() use ($input) {
			$slider       = new Slider();
            $slider->title = $input['title'];
            $slider->position = $input['position'];
            $slider->cover = $input['cover'];
            $slider->url = $input['url'];
            $slider->sort = isset($input['sort']) && strlen($input['sort']) > 0 && is_numeric($input['sort']) ? (int)$input['sort'] : 0;

			//See if this role has all permissions and set the flag on the role
//			$role->all = $all;

			if ($slider->save()) {
				return true;
			}

			throw new GeneralException(trans('exceptions.backend.slider.create_error'));
		});
    }

    /**
     * @param  Role $role
     * @param  $input
     * @throws GeneralException
     * @return bool
     */
    public function update(Slider $slider, $input)
    {
        //See if the role has all access, administrator always has all access
//        if ($slider->id == 1) {
//            $all = true;
//        } else {
//            $all = $input['associated-permissions'] == 'all' ? true : false;
//        }
//
//        if (! isset($input['permissions']))
//            $input['permissions'] = [];

        //This config is only required if all is false
//        if (! $all) {
//            //See if the role must contain a permission as per config
//            if (config('access.roles.role_must_contain_permission') && count($input['permissions']) == 0) {
//                throw new GeneralException(trans('exceptions.backend.access.roles.needs_permission'));
//            }
//        }

        $slider->title = $input['title'];
        $slider->position = $input['position'];
        $slider->cover = $input['cover'];
        $slider->url = $input['url'];
        $slider->sort = isset($input['sort']) && strlen($input['sort']) > 0 && is_numeric($input['sort']) ? (int)$input['sort'] : 0;

        //See if this role has all permissions and set the flag on the role
//        $role->all = $all;

		DB::transaction(function() use ($slider) {
			if ($slider->save()) {
				return true;
			}

			throw new GeneralException(trans('exceptions.backend.slider.update_error'));
		});
    }

    /**
     * @param  Role $role
     * @throws GeneralException
     * @return bool
     */
    public function destroy(Slider $slider)
    {
		DB::transaction(function() use ($slider) {
			if ($slider->delete()) {
				return true;
			}

			throw new GeneralException(trans('exceptions.backend.slider.delete_error'));
		});
    }
}
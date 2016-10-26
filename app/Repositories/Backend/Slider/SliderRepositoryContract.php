<?php

namespace App\Repositories\Backend\Slider;

use App\Models\Slider;

/**
 * Interface RoleRepositoryContract
 * @package app\Repositories\Role
 */
interface SliderRepositoryContract
{

    public function getCount();
	/**
     * @return mixed
     */
    public function getForDataTable();

    /**
     * @param  $input
     * @return mixed
     */
    public function create($input);

    /**
     * @param  Slider $slider
     * @param  $input
     * @return mixed
     */
    public function update(Slider $slider, $input);

    /**
     * @param  Slider $slider
     * @return mixed
     */
    public function destroy(Slider $slider);
}
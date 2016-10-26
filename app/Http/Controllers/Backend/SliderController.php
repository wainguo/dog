<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Repositories\Backend\Slider\SliderRepositoryContract;
use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class SliderController extends Controller
{
    protected $sliders;

    public function __construct(SliderRepositoryContract $sliders)
    {
        $this->sliders = $sliders;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.slider.index');
    }

    public function get()
    {
        return Datatables::of($this->sliders->getForDataTable())
            ->addColumn('actions', function($slider) {
                return '<a href="' . route('admin.slider.edit', $slider) . '" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="' . trans('buttons.general.crud.edit') . '"></i></a> '
                        .'<a href="' . route('admin.slider.destroy', $slider) . '" class="btn btn-xs btn-danger" data-method="delete"><i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="' . trans('buttons.general.crud.delete') . '"></i></a>';
            })
            ->make(true);
    }

    public function create()
    {
        $slider = new Slider();
        return view('backend.slider.create', [
            'slider' => $slider
        ])->withSliderCount($this->sliders->getCount());
    }

    public function store(Request $request)
    {
        $this->sliders->create($request->all());
        return redirect()->route('admin.slider.index')->withFlashSuccess(trans('alerts.backend.slider.created'));
    }

    public function edit(Slider $slider, Request $request)
    {
        return view('backend.slider.edit')
            ->withSlider($slider);
    }

    public function update(Slider $slider, Request $request)
    {
        $this->sliders->update($slider, $request->all());
        return redirect()->route('admin.slider.index')->withFlashSuccess(trans('alerts.backend.slider.updated'));
    }

    public function slider()
    {
//        $sliders = Slider::
        return view('backend.slider.list');
    }
}
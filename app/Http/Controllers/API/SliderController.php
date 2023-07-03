<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Models\Slider;
use App\Http\Resources\Slider as SliderResource;
   
class SliderController extends BaseController
{
    public function getSliders()
    {
        $sliders = Slider::all();
        return $this->sendResponse(SliderResource::collection($sliders), 'Data fetched.');
    }

}
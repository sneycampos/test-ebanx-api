<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class PlansController extends Controller
{
    protected $model;

    /**
     * PlansController constructor.
     * @param Plan $plan
     */
    public function __construct(Plan $plan)
    {
        $this->model = $plan;
    }


    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {
        $plans = $this->model->all();

        return view('plans', compact('plans'));
    }

    public function getOne($id)
    {
        return $this->model->find($id);
    }

}

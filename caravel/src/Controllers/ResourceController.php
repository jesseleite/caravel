<?php

namespace ThisVessel\Caravel\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use ThisVessel\Caravel\Traits\ResourceRouting;
use Illuminate\Foundation\Validation\ValidatesRequests;

class ResourceController extends Controller
{
    use ValidatesRequests, ResourceRouting;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($resource)
    {
        $this->isValidResourceType($resource);

        $model = $this->getModel($resource);
        $data = $this->prepareCommonData($resource);
        $data['items'] = $model::all()->reverse();

        return view('caravel::list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($resource)
    {
        $this->isValidResourceType($resource);

        $data = $this->prepareCommonData($resource);

        return view('caravel::create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($resource, Request $request)
    {
        $this->isValidResourceType($resource);

        $this->validate($request, $this->getValidationRules($resource));

        $model = $this->getModel($resource);
        $model::create($request->all());

        return redirect($this->routeIndex($resource));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($resource, $id)
    {
        $this->isValidResourceType($resource);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($resource, $id)
    {
        $this->isValidResourceType($resource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($resource, Request $request, $id)
    {
        $this->isValidResourceType($resource);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($resource, $id)
    {
        $this->isValidResourceType($resource);
    }

    public function isValidResourceType($resource)
    {
        if (! isset(config('caravel.resources')[$resource])) {
            return abort(404);
        }
    }

    public function prepareCommonData($resource)
    {

        return [
            'prefix'   => $this->routePrefix(),
            'resource' => $resource,
            'fields'   => $this->getFields($resource),
        ];
    }

    public function getModel($resource)
    {
        return config('caravel.resources')[$resource];
    }

    public function getFields($resource)
    {
        $model = $this->getModel($resource);

        return (new $model)->getCrudFields();
    }

    public function getValidationRules($resource)
    {
        $rules = [];

        foreach ($this->getFields($resource) as $field) {
            if ($field->required) {
                $rules[$field->name] = 'required';
            }
        }
        return $rules;
    }
}

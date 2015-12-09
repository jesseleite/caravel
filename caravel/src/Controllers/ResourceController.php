<?php

namespace ThisVessel\Caravel\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use ThisVessel\Caravel\Traits\SetsResource;
use Illuminate\Foundation\Validation\ValidatesRequests;

class ResourceController extends Controller
{
    use ValidatesRequests, SetsResource;

    public function __construct()
    {
        $this->setResource();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = $this->resource->modelClass;
        $data = $this->resource->commonViewData();
        $data['items'] = $model::all()->reverse();

        return view('caravel::list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = $this->resource->commonViewData();

        return view('caravel::form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->resource->validationRules());

        $model = $this->resource->modelClass;
        $model::create($request->all());

        return redirect($this->resource->baseUri);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->resource->commonViewData();

        $data['action'] = $this->resource->baseUri . '/' . $id;
        $data['model']  = $this->resource->find($id);

        return view('caravel::form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, $this->resource->validationRules());

        $model = $this->resource->find($id);
        // dd($request->all());
        $model->update($request->all());

        return redirect($this->resource->baseUri);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = $this->resource->modelClass;
        $model::destroy($id);

        return redirect($this->resource->baseUri);
    }
}

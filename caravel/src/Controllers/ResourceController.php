<?php

namespace ThisVessel\Caravel\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use ThisVessel\Caravel\Traits\SetsResource;
use Illuminate\Foundation\Validation\ValidatesRequests;

class ResourceController extends Controller
{
    use ValidatesRequests, SetsResource;

    /**
     * Resource helper object.
     *
     * @var \ThisVessel\Caravel\Resource
     */
    protected $resource;

    /**
     * Create a new resource controller instance.
     *
     * @return void
     */
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

        return view('caravel::pages.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = $this->resource->commonViewData();

        return view('caravel::pages.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->resource->rules);

        $model = $this->resource->modelClass;
        $model::create($request->all());

        session()->flash('success', ucfirst(str_singular($this->resource->key)) . ' was created successfully!');

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
        return abort(404);
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

        return view('caravel::pages.form', $data);
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
        $this->validate($request, $this->resource->rules);

        $model = $this->resource->find($id);
        $model->update($request->all());

        session()->flash('success', ucfirst(str_singular($this->resource->key)) . ' was updated successfully!');

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

        session()->flash('success', ucfirst(str_singular($this->resource->key)) . ' was deleted successfully!');

        return redirect($this->resource->baseUri);
    }
}

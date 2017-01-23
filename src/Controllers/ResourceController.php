<?php

namespace ThisVessel\Caravel\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use ThisVessel\Caravel\Helpers\Drawbridge;
use ThisVessel\Caravel\Traits\SetsResource;
use ThisVessel\Caravel\Traits\UploadsFiles;
use ThisVessel\Caravel\Requests\ResourceRequest;

class ResourceController extends Controller
{
    use SetsResource, UploadsFiles;

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
    public function index(Request $request)
    {
        Drawbridge::authorize('manage', $this->resource->newInstance);

        if ($this->resource->searchable() && $request->search) {
            $this->resource->search($request->search);
            $search = $request->search;
            $getParams['search'] = $request->search;
        }

        if ($this->resource->softDeletes && $request->trash) {
            $this->resource->trashed($request->trash);
            $getParams['trash'] = $request->trash;
        }

        $data = array_merge($this->resource->commonViewData(), [
            'items' => $this->resource->paginate(config('caravel.pagination')),
            'searchable' => $this->resource->searchable(),
            'search' => isset($search) ? $search : null,
            'getParams' => isset($getParams) ? $getParams : [],
        ]);

        return view('caravel::pages.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Drawbridge::authorize('create', $this->resource->newInstance);

        $data = array_merge($this->resource->commonViewData(), [
            'action' => route('caravel::' . $this->resource->name . '.store'),
            'model' => $this->resource->newInstance,
            'bindable' => $this->resource->newInstance,
        ]);

        return view('caravel::pages.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ResourceRequest $request)
    {
        Drawbridge::authorize('create', $this->resource->newInstance);

        $data = $this->prepareInputData($request);

        $created = $this->resource->createWithRelations($request);

        $this->uploadFiles($request, $created);

        session()->flash('success', ucfirst(str_singular($this->resource->name)) . ' was created successfully!');

        return redirect()->route('caravel::' . $this->resource->name . '.index');
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
        $model = $this->resource->find($id);

        Drawbridge::authorize('update', $model);

        $data = array_merge($this->resource->commonViewData(), [
            'action' => route('caravel::' . $this->resource->name . '.update', $model),
            'model' => $model,
            'bindable' => $this->resource->bindable($model),
        ]);

        return view('caravel::pages.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ResourceRequest $request, $id)
    {
        $model = $this->resource->find($id);

        Drawbridge::authorize('update', $model);

        $data = $this->prepareInputData($request);

        $this->resource->updateWithRelations($request, $model);

        $this->uploadFiles($request, $model);

        session()->flash('success', ucfirst(str_singular($this->resource->name)) . ' was updated successfully!');

        return redirect()->route('caravel::' . $this->resource->name . '.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = $this->resource->find($id);

        Drawbridge::authorize('delete', $model);

        $model->delete();

        session()->flash('success', ucfirst(str_singular($this->resource->name)) . ' was deleted successfully!');

        return redirect()->route('caravel::' . $this->resource->name . '.index');
    }

    /**
     * Restore the resource if soft deleted.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! $this->resource->softDeletes) {
            return abort(405, 'This resource does not allow soft deletes.');
        }

        $model = $this->resource->withTrashed()->find($id);

        Drawbridge::authorize('delete', $model);

        $model->restore();

        return redirect()->route('caravel::' . $this->resource->name . '.index');
    }
}

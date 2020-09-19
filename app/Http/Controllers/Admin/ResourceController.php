<?php

namespace App\Http\Controllers\Admin;

use App\Resource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResourceController extends Controller
{
    public function index() {
        return view('admin.resource.index')->with('resources', Resource::all());
    }

    public function create() {
        return view('admin.resource.create')->with('resource', new Resource());
    }

    public function edit(Resource $resource)
    {
        return view('admin.resource.create')->with('resource', $resource);
    }
    public function store(Request $request)
    {
        $result = $this->saveData($request, new Resource());
        if ($result) {
            return redirect()->route('admin.resource.create')
                ->with('success', 'Ресурс успешно добавлен');
        } else {
            $request->flash();
            return redirect()->route('admin.resource.create')
                ->with('error', 'Ошибка добавления ресурса!');
        }
    }
    public function destroy(Resource $resource)
    {
        $result = $resource->delete();
        if ($result) {
            return redirect()->route('admin.resource.index')
                ->with('success', 'Категория успешно удалена');
        } else {
            return redirect()->route('admin.resource.index')
                ->with('error', 'Ошибка удаления ресурса!');
        }

    }
    public function update(Request $request, Resource $resource)
    {
        $result = $this->saveData($request, $resource);
        if ($result) {
            return redirect()->route('admin.resource.index')
                ->with('success', 'Ресурс успешно изменён');
        } else {
            $request->flash();
            return redirect()->route('admin.resource.create')
                ->with('error', 'Ошибка изменения ресурса!');
        }

    }

    private function saveData(Request $request, Resource $resource)
    {
        $data = $request->except(['_token', '_method']);
        $this->validate($request, Resource::rules());
        return $resource->fill($data)->save();

    }
}

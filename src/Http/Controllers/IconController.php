<?php

namespace Selene\Modules\IconModule\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Selene\Modules\DashboardModule\ZdrojowaTable;
use Selene\Modules\IconModule\Models\Icon;

class IconController extends Controller
{
    public function index(Request $request)
    {
        return view('IconModule::index');
    }

    public function ajax(Request $request): JsonResponse
    {
        return ZdrojowaTable::response(Icon::query(), $request);
    }

    public function create()
    {
        return view('IconModule::edit');
    }

    public function edit(Icon $icon = null)
    {
        return view('IconModule::edit', ['icon' => $icon]);
    }

    public function store(Request $request)
    {
        $icon = $this->save($request);
        if ($icon) {
            $request->session()->flash('alert-success', 'Ikonka pomyślnie dodana.');
        } else {
            $request->session()->flash('alert-error', 'Ooops. Try again.');
        }

        return ['redirect' => route('IconModule::edit', ['icon' => $icon])];
    }

    public function update(Request $request, Icon $icon)
    {
        if ($this->save($request, $icon)) {
            $request->session()->flash('alert-success', 'Ikonka została pomyślnie zaktualizowana.');
        } else {
            $request->session()->flash('alert-error', 'Ooops. Try again.');
        }

        return ['redirect' => route('IconModule::edit', ['icon' => $icon])];
    }

    private function save(Request $request, Icon $icon = null) {
        if ($icon === null) {
            return Icon::create($request->all());
        }

        $icon->update($request->all());
        return $icon;
    }

    public function destroy(Icon $icon, Request $request): void
    {
        try {
            $icon->delete();
            $request->session()->flash('alert-success', 'Ikonka usunięta');
        } catch (Exception $e) {
            $request->session()->flash('alert-error', 'Error: ' . $e->getMessage());
        }
    }
}

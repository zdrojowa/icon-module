<?php

namespace Selene\Modules\IconModule\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Selene\Modules\IconModule\Models\Icon;
use Selene\Modules\LanguageModule\Models\Language;

class IconController extends Controller
{
    public function index()
    {
        return view('IconModule::index');
    }

    public function create()
    {
        return view('IconModule::edit', [
            'langs' => Language::all()
        ]);
    }

    public function edit(Icon $icon = null)
    {
        return view('IconModule::edit', [
            'icon'  => $icon,
            'langs' => Language::all()
        ]);
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
        $request->merge(['translations' => json_decode($request->get('translations'))]);
        if ($icon === null) {
            return Icon::query()->create($request->all());
        }

        $icon->update($request->all());
        return $icon;
    }
}

<?php

namespace Selene\Modules\IconModule\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Selene\Modules\IconModule\Models\Icon;

class ApiController extends Controller
{
    public function get(Request $request): JsonResponse
    {
        $icons = Icon::query()->orderBy('name');

        if ($request->has('id')) {
            $icons->where('_id', '=', $request->get('id'));
            return response()->json($icons->first());
        }

        if ($request->has('per_page')) {
            return response()->json(
                $icons->paginate(
                    $request->get('per_page') >> 0,
                    ['*'],
                    'page',
                    $request->get('page', 1)
                )
            );
        }

        return response()->json($icons->get());
    }
}

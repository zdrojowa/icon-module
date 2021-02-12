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

        $search = $request->get('search');
        if (!empty($search)) {
            $icons->where(function($query) use ($search) {
                $query->where('_id', '=', $search)
                    ->orWhere('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('translations', 'LIKE', '%' . $search . '%');
            });
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

    public function checkKey(Request $request): JsonResponse
    {
        $key = $request->get('key');
        if (empty($key)) {
            return response()->json(['message' => 'Key is required'],JsonResponse::HTTP_BAD_REQUEST);
        }
        $exists = Icon::query();
        if ($request->has('id')) {
            $exists->where('_id', '!=', $request->get('id'));
        }
        return response()->json(!$exists->where('name', '=', $key)->exists());
    }

    public function remove(Icon $icon): JsonResponse
    {
        try {
            $icon->delete();
            return response()->json(['message' => 'Ikonka usunięta']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()],JsonResponse::HTTP_BAD_REQUEST);
        }
    }
}

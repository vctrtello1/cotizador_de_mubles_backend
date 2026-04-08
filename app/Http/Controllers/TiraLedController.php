<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTiraLedRequest;
use App\Http\Requests\UpdateTiraLedRequest;
use App\Models\TiraLed;
use Illuminate\Http\JsonResponse;

class TiraLedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => TiraLed::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTiraLedRequest $request): JsonResponse
    {
        $tiraLed = TiraLed::create($request->validated());
        
        return response()->json([
            'data' => $tiraLed,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(TiraLed $tiraLed): JsonResponse
    {
        return response()->json([
            'data' => $tiraLed,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTiraLedRequest $request, TiraLed $tiraLed): JsonResponse
    {
        $tiraLed->update($request->validated());
        
        return response()->json([
            'data' => $tiraLed,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TiraLed $tiraLed): JsonResponse
    {
        $tiraLed->delete();
        
        return response()->json(null, 204);
    }
}

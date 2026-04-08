<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWhatsPorMetroRequest;
use App\Http\Requests\UpdateWhatsPorMetroRequest;
use App\Http\Resources\WhatsPorMetroResource;
use App\Models\WhatsPorMetro;

class WhatsPorMetroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return WhatsPorMetroResource::collection(WhatsPorMetro::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWhatsPorMetroRequest $request)
    {
        $whatsPorMetro = WhatsPorMetro::create($request->validated());

        return new WhatsPorMetroResource($whatsPorMetro);
    }

    /**
     * Display the specified resource.
     */
    public function show(WhatsPorMetro $whatsPorMetro)
    {
        return new WhatsPorMetroResource($whatsPorMetro);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWhatsPorMetroRequest $request, WhatsPorMetro $whatsPorMetro)
    {
        $whatsPorMetro->update($request->validated());

        return new WhatsPorMetroResource($whatsPorMetro);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WhatsPorMetro $whatsPorMetro)
    {
        $whatsPorMetro->delete();

        return response()->noContent();
    }
}

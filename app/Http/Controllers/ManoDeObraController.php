<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreManoDeObraRequest;
use App\Http\Requests\UpdateManoDeObraRequest;
use App\Http\Resources\ManoDeObraResource;
use App\Models\ManoDeObra;

class ManoDeObraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ManoDeObraResource::collection(ManoDeObra::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreManoDeObraRequest $request)
    {
        $manoDeObra = ManoDeObra::create($request->validated());
        return new ManoDeObraResource($manoDeObra);
    }

    /**
     * Display the specified resource.
     */
    public function show(ManoDeObra $manoDeObra)
    {
        if (request()->query('include') === 'componentes') {
            $manoDeObra->load('componentes');
        }
        return new ManoDeObraResource($manoDeObra);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateManoDeObraRequest $request, ManoDeObra $manoDeObra)
    {
        $manoDeObra->update($request->validated());
        return new ManoDeObraResource($manoDeObra);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ManoDeObra $manoDeObra)
    {
        $manoDeObra->delete();
        return response()->noContent();
    }
}

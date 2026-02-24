<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAccesoriosPorComponenteRequest;
use App\Http\Requests\UpdateAccesoriosPorComponenteRequest;
use App\Http\Resources\AccesoriosPorComponenteResource;
use App\Models\Accesorio;
use App\Models\AccesoriosPorComponente;

class AccesoriosPorComponenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return AccesoriosPorComponenteResource::collection(AccesoriosPorComponente::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAccesoriosPorComponenteRequest $request)
    {
        $payload = $request->validated();
        if (isset($payload['accesorio_id'])) {
            $payload['accesorio'] = Accesorio::query()->whereKey($payload['accesorio_id'])->value('nombre');
            unset($payload['accesorio_id']);
        }

        $accesoriosPorComponente = AccesoriosPorComponente::create($payload);

        return new AccesoriosPorComponenteResource($accesoriosPorComponente);
    }

    /**
     * Display the specified resource.
     */
    public function show(AccesoriosPorComponente $accesoriosPorComponente)
    {
        return new AccesoriosPorComponenteResource($accesoriosPorComponente);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAccesoriosPorComponenteRequest $request, AccesoriosPorComponente $accesoriosPorComponente)
    {
        $payload = $request->validated();
        if (isset($payload['accesorio_id'])) {
            $payload['accesorio'] = Accesorio::query()->whereKey($payload['accesorio_id'])->value('nombre');
            unset($payload['accesorio_id']);
        }

        $accesoriosPorComponente->update($payload);

        return new AccesoriosPorComponenteResource($accesoriosPorComponente);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AccesoriosPorComponente $accesoriosPorComponente)
    {
        $accesoriosPorComponente->delete();

        return response()->noContent();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Http\Resources\ClienteResource;
use App\Http\Resources\CotizacionResource;
use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        return ClienteResource::collection(Cliente::all());
    }

    public function store(StoreClienteRequest $request)
    {
        $cliente = Cliente::create($request->validated());
        return new ClienteResource($cliente);
    }

    public function show(Cliente $cliente)
    {
        return new ClienteResource($cliente);
    }

    public function update(UpdateClienteRequest $request, Cliente $cliente)
    {
        $cliente->update($request->validated());
        return new ClienteResource($cliente);
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return response()->noContent();
    }

    public function cotizaciones(Request $request, Cliente $cliente)
    {
        $query = $cliente->cotizaciones()->with('detalles');

        // Filtering
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('fecha', [$request->start_date, $request->end_date]);
        }

        // Sorting
        if ($request->has('sort_by') && $request->has('order')) {
            $query->orderBy($request->sort_by, $request->order);
        }

        // Pagination
        if ($request->has('per_page')) {
            return CotizacionResource::collection($query->paginate($request->per_page));
        }

        return CotizacionResource::collection($query->get());
    }
}

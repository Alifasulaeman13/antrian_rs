<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Loket;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LoketController extends Controller
{
    public function index()
    {
        return response()->json(Loket::orderBy('nama_loket')->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_loket' => 'required|string|max:255|unique:lokets,nama_loket',
            'deskripsi' => 'nullable|string',
            'kode_prefix' => 'nullable|string|max:5',
        ]);

        $loket = Loket::create($data);
        return response()->json($loket, Response::HTTP_CREATED);
    }

    public function show(Loket $loket)
    {
        return response()->json($loket);
    }

    public function update(Request $request, Loket $loket)
    {
        $data = $request->validate([
            'nama_loket' => 'required|string|max:255|unique:lokets,nama_loket,' . $loket->id,
            'deskripsi' => 'nullable|string',
            'kode_prefix' => 'nullable|string|max:5',
        ]);

        $loket->update($data);
        return response()->json($loket);
    }

    public function destroy(Loket $loket)
    {
        $loket->delete();
        return response()->noContent();
    }
}
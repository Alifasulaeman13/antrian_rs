<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Antrian;
use App\Models\Loket;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class AntrianController extends Controller
{
    public function generate(Request $request, Loket $loket)
    {
        $prefix = $loket->kode_prefix ?? 'A';

        $antrian = DB::transaction(function () use ($loket, $prefix) {
            $last = Antrian::where('loket_id', $loket->id)
                ->orderByDesc('id')
                ->lockForUpdate()
                ->first();

            $nextNumber = 1;
            if ($last) {
                if (preg_match('/\D*(\d+)/', $last->nomor_antrian, $m)) {
                    $nextNumber = ((int) $m[1]) + 1;
                }
            }

            $nomor = sprintf('%s%03d', $prefix, $nextNumber);

            return Antrian::create([
                'loket_id' => $loket->id,
                'nomor_antrian' => $nomor,
                'status' => 'menunggu',
            ]);
        });

        return response()->json($antrian, Response::HTTP_CREATED);
    }

    public function updateStatus(Request $request, Antrian $antrian)
    {
        $data = $request->validate([
            'status' => 'required|in:menunggu,dipanggil,selesai',
        ]);

        $antrian->status = $data['status'];
        if ($data['status'] === 'dipanggil') {
            $antrian->waktu_panggil = now();
        } elseif ($data['status'] === 'menunggu') {
            $antrian->waktu_panggil = null;
        }
        $antrian->save();

        return response()->json($antrian);
    }

    public function currentCalled(Request $request)
    {
        $loketId = $request->query('loket_id');
        $query = Antrian::with('loket')->where('status', 'dipanggil');
        if ($loketId) {
            $query->where('loket_id', $loketId);
        }
        $data = $query->orderBy('waktu_panggil', 'desc')->get();
        return response()->json($data);
    }

    public function listWaiting(Loket $loket)
    {
        $data = Antrian::where('loket_id', $loket->id)
            ->where('status', 'menunggu')
            ->orderBy('created_at')
            ->get();
        return response()->json($data);
    }
}
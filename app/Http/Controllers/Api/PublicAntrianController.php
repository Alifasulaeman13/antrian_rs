<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Antrian;
use App\Models\Loket;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class PublicAntrianController extends Controller
{
    public function generate(Request $request, Loket $loket)
    {
        $prefix = $loket->kode_prefix ?? 'A';
        $today = now()->toDateString();

        $antrian = DB::transaction(function () use ($loket, $prefix, $today) {
            $last = Antrian::where('loket_id', $loket->id)
                ->where('tanggal', $today)
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
                'tanggal' => $today,
                'nomor_antrian' => $nomor,
                'status' => 'menunggu',
            ]);
        });

        return response()->json($antrian, Response::HTTP_CREATED);
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
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    private function getSubkomponenData()
    {
        // Ambil data dari session yang disimpan oleh CsvController
        $sessionData = session('subkomponen_data');
        
        if ($sessionData) {
            return $sessionData;
        } else {
            // Jika tidak ada data di session, kembalikan array kosong
            return [];
        }
    }

    public function index()
    {
        $subkomponenData = $this->getSubkomponenData();
        return view('assessment', compact('subkomponenData'));
    }

    public function getSubkomponenOptions()
    {
        $subkomponenData = $this->getSubkomponenData();
        return response()->json([
            'success' => true,
            'data' => $subkomponenData
        ]);
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'input1' => 'required|numeric|min:1|max:100',
            'input2' => 'required|numeric|min:1|max:100', 
            'input3' => 'required|numeric|min:1|max:100',
            'subkomponen' => 'required|string',
            'koreksi' => 'required|in:koreksi,belum_koreksi'
        ]);

        // Hitung rata-rata dari 3 angka
        $average = ($request->input1 + $request->input2 + $request->input3) / 3;

        // Ambil data subkomponen untuk mendapatkan bobot
        $subkomponenData = $this->getSubkomponenData();
        $selectedSubkomponen = null;
        
        foreach ($subkomponenData as $data) {
            if ($data['subkomponen'] === $request->subkomponen) {
                $selectedSubkomponen = $data;
                break;
            }
        }

        if (!$selectedSubkomponen) {
            return response()->json([
                'success' => false,
                'message' => 'Subkomponen tidak ditemukan'
            ], 400);
        }

        // Tentukan persentase berdasarkan status koreksi dan data dari CSV
        if ($request->koreksi === 'belum_koreksi') {
            $percentage = $selectedSubkomponen['bobotsubkomponen'];
        } else {
            $percentage = $selectedSubkomponen['bobotsubkomponenkoreksi'];
        }

        // Hitung hasil akhir
        $finalScore = $average * $percentage;

        return response()->json([
            'success' => true,
            'data' => [
                'input1' => $request->input1,
                'input2' => $request->input2,
                'input3' => $request->input3,
                'average' => round($average, 2),
                'percentage' => $percentage * 100,
                'finalScore' => round($finalScore, 2),
                'subkomponen' => $request->subkomponen,
                'koreksi' => $request->koreksi
            ]
        ]);
    }
}

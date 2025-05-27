<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\Csv\Reader;
use Maatwebsite\Excel\Facades\Excel;

class CsvController extends Controller
{
    //
    public function upload()
    {
        return view('csv.upload');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');

        $data = Excel::toArray([], $file);

        // Ambil sheet pertama
        $rows = $data[0];

        $dataExcel = [];

        // Loop dari baris ke-2 karena baris pertama biasanya header
        for ($i = 1; $i < count($rows); $i++) {
            $row = $rows[$i];

            $dataExcel[] = [
                'subkomponen' => $row[7], // kolom 0 = Sub Komponen
                'bobotsubkomponen' => $row[8], // kolom 1 = Bobot Sub Komponen
                'bobotsubkomponenkoreksi' => $row[9], // kolom 2 = Bobot Sub komponen Koreksi
            ];
        }

        $result = [];
        foreach ($dataExcel as $data) {
            if ($data['subkomponen'] == "Sarana Pemilahan Sampah" || $data['subkomponen'] == "Proses Pemilahan Sampah") {
                $result[] = [
                    'subkomponen' => $data['subkomponen'],
                    'bobotsubkomponen' => $data['bobotsubkomponen'],
                    'bobotsubkomponenkoreksi' => $data['bobotsubkomponenkoreksi'],
                ];
            }
        }
        return response()->json($result);
    }
}

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
            'file' => 'required|file|mimes:csv,xlsx,xls',
        ]);

        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();

        if ($extension === 'csv') {
            // Handle CSV files
            return $this->importCsv($file);
        } else {
            // Handle Excel files
            return $this->importExcel($file);
        }
    }

    private function importCsv($file)
    {
        $csv = Reader::createFromPath($file->getRealPath(), 'r');
        $csv->setHeaderOffset(0); // First row as header
        
        $records = $csv->getRecords();
        $dataExcel = [];
        
        foreach ($records as $record) {
            // Adjust column names based on your CSV structure
            $dataExcel[] = [
                'subkomponen' => $record['subkomponen'] ?? $record['Sub Komponen'] ?? '',
                'bobotsubkomponen' => $record['bobotsubkomponen'] ?? $record['Bobot Sub Komponen'] ?? 0,
                'bobotsubkomponenkoreksi' => $record['bobotsubkomponenkoreksi'] ?? $record['Bobot Sub komponen Koreksi'] ?? 0,
            ];
        }
        
        return $this->processData($dataExcel);
    }

    private function importExcel($file)
    {
        $data = Excel::toArray(new \stdClass(), $file);

        // Ambil sheet pertama
        $rows = $data[0];

        $dataExcel = [];

        // Loop dari baris ke-2 karena baris pertama biasanya header
        for ($i = 1; $i < count($rows); $i++) {
            $row = $rows[$i];

            $dataExcel[] = [
                'subkomponen' => $row[7], // kolom 7 = Sub Komponen
                'bobotsubkomponen' => $row[8], // kolom 8 = Bobot Sub Komponen
                'bobotsubkomponenkoreksi' => $row[9], // kolom 9 = Bobot Sub komponen Koreksi
            ];
        }
        
        return $this->processData($dataExcel);
    }

    private function processData($dataExcel)
    {
        $result = [];
        foreach ($dataExcel as $data) {
            if ($data['subkomponen'] == "Sarana Pemilahan Sampah" || $data['subkomponen'] == "Proses Pemilahan Sampah") {
                $result[] = [
                    'subkomponen' => $data['subkomponen'],
                    'bobotsubkomponen' => floatval($data['bobotsubkomponen']),
                    'bobotsubkomponenkoreksi' => floatval($data['bobotsubkomponenkoreksi']),
                ];
            }
        }
        
        // Simpan data di session untuk digunakan di assessment
        session(['subkomponen_data' => $result]);
        
        return redirect()->route('csv.upload')->with('success', 'File berhasil diupload dan data telah disimpan! ' . count($result) . ' data subkomponen ditemukan.');
    }
}

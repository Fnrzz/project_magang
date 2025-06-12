<?php

namespace App\Http\Controllers;

use App\Imports\AdipuraImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AssessmentController extends Controller
{
    public function index()
    {
        // Reset semua session saat halaman dimuat (sesuai requirement)
        session()->forget(['nilaiOrisinalAdipura', 'nilaiKoreksiAdipura', 'file_uploaded_adipura']);
        return view('assessment');
    }

    public function uploadAdipura(Request $request)
    {
        // Validasi file Excel saja
        $request->validate([
            'file_adipura' => 'required|file|mimes:xls,xlsx|max:10240'
        ]);

        try {
            $array = Excel::toArray(new AdipuraImport, $request->file('file_adipura'));

            // Pastikan data array tidak kosong dan memiliki struktur yang benar
            if (empty($array) || empty($array[0]) || !isset($array[0][25])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Format file Excel tidak sesuai atau data pada baris 26 tidak ditemukan'
                ]);
            }

            // Ambil nilai dari cell L26 dan M26 (row 26 = index 25, kolom L=11 dan M=12 dalam 0-based index)
            $nilaiOrisinal = isset($array[0][26][11]) && $array[0][26][11] !== null
                ? number_format(floatval($array[0][26][11]), 2, '.', '')
                : '67.00';
            $nilaiKoreksi = isset($array[0][26][12]) && $array[0][26][12] !== null
                ? number_format(floatval($array[0][26][12]), 2, '.', '')
                : '69.00';

            // Simpan nilai ke session terpisah sesuai requirement
            session([
                'nilaiOrisinalAdipura' => $nilaiOrisinal,
                'nilaiKoreksiAdipura' => $nilaiKoreksi,
                'file_uploaded_adipura' => true
            ]);

            return response()->json([
                'success' => true,
                'message' => 'File berhasil diupload dan nilai berhasil disimpan!',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses file Excel: ' . $e->getMessage()
            ]);
        }
    }

    public function calculateOrisinalAdipura()
    {

        if (!session('nilaiOrisinalAdipura') || !session('file_uploaded_adipura')) {
            return response()->json([
                'success' => false,
                'message' => 'File Excel belum diupload!'
            ]);
        }

        return response()->json([
            'success' => true,
            'nilai' => session('nilaiOrisinalAdipura')
        ]);
    }

    public function calculateKoreksiAdipura()
    {
        if (!session('file_uploaded_adipura')) {
            return response()->json([
                'success' => false,
                'message' => 'File Excel belum diupload!'
            ]);
        }

        return response()->json([
            'success' => true,
            'nilai' => session('nilaiKoreksiAdipura')
        ]);
    }
}

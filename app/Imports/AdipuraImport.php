<?php

namespace App\Imports;

// use App\Models\Adipura;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class AdipuraImport implements ToArray, WithCalculatedFormulas
{
    /**
    * @param array $rows
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function array(array $rows)
    {
        return $rows;
    }
}

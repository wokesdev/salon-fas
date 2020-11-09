<?php

namespace App\Imports;

use App\Models\Purchase;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PurchasesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Purchase([
            'nomor_pembelian' => $row['nomor_pembelian'],
            'supplier_id' => $row['supplier_id'],
            'account_detail_id' => $row['account_detail_id'],
            'tanggal' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal'])),
        ]);
    }
}

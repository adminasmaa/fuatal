<?php

namespace App\Imports;

use Illuminate\Validation\Rule;
use App\Models\CreditNumber;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Validator;
use Auth;

class CreditNumberImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        Validator::make($rows->toArray(), [
            '*.company' => 'required',
            '*.number' => 'required|digits_between:14,16|unique:credit_numbers,number',
        ])->validate();
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new CreditNumber([
            'tel_company_id'     => $row['company'],
            'number'    => $row['number'],
            'credit_amount'    => $row['credit_amount'],
            'expire_date'    => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['expire_date']),
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id,
        ]);
    }
}

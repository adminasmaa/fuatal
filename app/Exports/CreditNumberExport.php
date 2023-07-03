<?php

namespace App\Exports;

use App\Models\CreditNumber;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CreditNumberExport implements FromCollection, WithMapping, WithHeadings
{
    protected $company;

    function __construct($company=0)
    {
        $this->company = $company;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        if ($this->company) {
            return CreditNumber::where('tel_company_id', $this->company)->with('company')->get();
        } else {
            return CreditNumber::with('company')->get();
        }
    }

    public function map($creditNumber): array
    {
        return [
            $creditNumber->id,
            $creditNumber->number,
            $creditNumber->company->name,
            $creditNumber->company->id
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Number',
            'Company Name',
            'Company Id'
        ];
    }
}

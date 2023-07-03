<?php

namespace App\Http\Controllers\Admin;

use App\Base\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\TelCompany;
use App\Exports\CreditNumberExport;
use App\Imports\CreditNumberImport;
use App\Models\CompanyQuota;
use App\Models\CreditNumber;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use PDF;

class TelCompanyController extends AdminController
{

    public function index()
    {
        $tcompanies = TelCompany::all();
        return view('tcompany.index', ['tcompanies' => $tcompanies]);
    }

    public function create()
    {
        return view('tcompany.create');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
                'prefix' => 'required',
                'name' => 'required'
            ],
            [
                'logo.required' => 'Logo field is required',
                'logo.mimes' => 'Logo field only accept Image file',
                'logo.mimes' => 'Logo field only accept Image file',
                'prefix.required' => 'Prefix field is required',
                'name.required' => "Name field is required"
            ]
        );
        if ($request->hasFile('logo')) {
            $logo_name = time() . '_logo.' . $request->logo->extension();
            $request->logo->move(public_path('uploads/categories'), $logo_name);
        }
        TelCompany::create([
            'prefix' => $request->prefix,
            'logo' => $logo_name,
            'name' => $request->name
        ]);
        return redirect()->back()->with('success', 'Company Created Successfully');
    }

    public function edit($id)
    {
        $telcompany = TelCompany::where('id', $id)->first();
        return view('tcompany.edit', ['tcompany' => $telcompany]);
    }

    public function update($id, Request $request)
    {
        $tel_c = TelCompany::where('id', $id)->first();
        $logo_name = $tel_c->logo;
        $request->validate(
            [
                'logo' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg',
                'prefix' => 'required',
                'name' => 'required'
            ],
            [
                'logo.image' => 'Logo field only accept Image file',
                'logo.mimes' => 'Logo field only accept Image file',
                'prefix.required' => 'Prefix field is required',
                'name.required' => "Name field is required"
            ]
        );
        if ($request->hasFile('logo')) {
            $logo_name = time() . '_logo.' . $request->logo->extension();
            $request->logo->move(public_path('uploads/categories'), $logo_name);
        }
        $telcompany = TelCompany::where('id', $id)->update([
            'prefix' => $request->prefix,
            'logo' => $logo_name,
            'name' => $request->name
        ]);
        return redirect()->back()->with('success', 'Company updated successfully');
    }

    public function destroy($id)
    {
        TelCompany::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Compamy deleted successfully');
    }

    public function export()
    {
        return Excel::download(new CreditNumberExport, 'CreditNumbers.xlsx');
    }
    public function exportOfCompany($company)
    {
        return Excel::download(new CreditNumberExport($company), 'CreditNumbers.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate(
            [
                'file' => 'required',
            ],
            ['file.required' => 'Please upload file first']
        );
        try {
            Excel::import(new CreditNumberImport, $request->file('file'));
        } catch (\Maatwebsite\Excel\Validators\ValidationException $failures) {
            return redirect()->back()->with('failures', $failures);
        }
        return redirect()->back()->with('success', 'Data imported Succesfully');
    }

    public function creditNumbers($company_id, Request $request)
    {
        $limit = $request->limit ?? 10;
        $tcompany = TelCompany::where('id', $company_id)->first();
        $numbers = CreditNumber::where('tel_company_id', $company_id)->orderby('number', 'asc')->paginate($limit);
        // $numbers = CreditNumber::where('tel_company_id', $company_id)->where('expired', 0)->get();
        return view('tcompany.credit-listing', ['numbers' => $numbers, 'tcompany' => $tcompany, 'limit' => $limit]);
    }

    public function allCreditNumbers(Request $request)
    {
        $companies = TelCompany::all();
        $limit = $request->limit ?? 10;
        $numbers = CreditNumber::whereHas('company', function ($sq) use ($request) {
            $sq->when($request->company, function ($sqq) use ($request) {
                $sqq->where('prefix', $request->company);
            });
        })->when($request->status == '0', function ($sq) {
            $sq->whereExpired(0);
        })->when($request->status == '1', function ($sq) {
            $sq->whereExpired(1);
        })->when($request->search, function ($sq) use ($request) {
            $sq->where('number', 'like', '%' . $request->search . '%')
                ->orWhere(function ($ssq) use ($request) {
                    $ssq->whereHas('company', function ($cq) use ($request) {
                        $cq->where('name', 'like', '%' . $request->search . '%');
                    });
                });
        })->orderby('created_at', 'desc')->paginate($limit);
        // $numbers = CreditNumber::where('tel_company_id', $company_id)->where('expired', 0)->get();
        return view('tcompany.all-credit-listing', ['companies' => $companies, 'numbers' => $numbers, 'limit' => $limit]);
    }

    public function downloadSampleImportNumbers()
    {
        $file = public_path() . "/numberExport/Number-Export-Sample.xlsx";
        return response()->download($file);
    }

    public function addCreditNumber(Request $request)
    {
        $request->validate(
            [
                'company_id' => 'required',
                'number' => 'required|unique:credit_numbers,number|digits_between:14,16',
            ],
            [
                'company_id.required' => 'Company always required',
                'number.required' => 'Number cannot be blank',
                'number.unique' => 'Number already exists'
            ]
        );
        CreditNumber::create([
            'number' => $request->number,
            'tel_company_id' => $request->company_id
        ]);
        return redirect()->back()->with('success', 'Credit Number added successfully');
    }

    public function exportPdfNumbers(Request $request)
    {
        $request->validate(
            [
                'from' => 'required|numeric|min:1',
                'to' => 'required|numeric|min:1|gte:from',
            ],
            [
                'from.required' => 'Start field is required',
                'from.min' => 'Start field must have at least 1 as value',
                'from.numeric' => 'Start field only can accept numeric value',
                'to.numeric' => 'End field only can accept numeric value',
                'to.min' => 'End field must have at least 1 as value',
                'to.required' => 'End field is required',
                'to.gte' => 'End number should be greater than or equal to Start number',
            ]
        );
        $skip = $request->from - 1;
        $take = ($request->to - $request->from) + 1;
        if (isset($request->company_id) && $request->company_id != '') {
            $numbers = CreditNumber::where('tel_company_id', $request->company_id)->skip($skip)->take($take)->orderby('number', 'asc')->get();
        } else {
            $numbers = CreditNumber::skip($skip)->take($take)->orderby('number', 'asc')->get();
        }
        $data['numbers'] = $numbers;
        $pdf = PDF::loadView('tcompany.exportPdf', $data);
        return $pdf->download('Credit Numbers.pdf');
    }

    public function assignQuota($company_id)
    {
        $company = TelCompany::where('id', $company_id)->first();
        $available = CreditNumber::where('tel_company_id', $company_id)->where('expired', 0)->count();
        $sum = CompanyQuota::where('company_id', $company_id)->where('to', '>=', now())->sum('qouta');
        if ($available < $sum) {
            $available = $sum;
        }
        return view('tcompany.assign-code-form', ['company' => $company, 'available' => $available - $sum]);
    }

    public function assignQuotaSave(Request $request)
    {
        $request->validate([
            'date_range' => 'required',
            'percentage' => 'required',
        ], [
            'date_range.required' => 'Date Range Field is required',
            'percentage.required' => 'Percentage Field is required',
        ]);
        $dates = explode(' - ', $request->date_range);
        $from = $dates[0];
        $to = $dates[1];
        $total = CreditNumber::where('tel_company_id', $request->company_id)->where('expired', 0)->count();
        $quota = ($total * $request->percentage) / 100;
        $used = 0;
        CompanyQuota::create([
            'company_id' => $request->company_id,
            'from' => date('Y-m-d H:i:s', strtotime($from)),
            'to' => date('Y-m-d H:i:s', strtotime($to)),
            'qouta' => $quota,
            'used' => $used,
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id
        ]);
        return redirect()->back()->with('success', 'Quota is assigned successfully');
    }

    public function viewQuota($id)
    {
        $company = TelCompany::where('id', $id)->first();
        $limit = request()->limit ?? 10;
        $quotas = CompanyQuota::where('company_id', $id)->paginate($limit);
        return view('tcompany.viewQuota', ['company' => $company, 'quotas' => $quotas, 'limit' => $limit]);
    }
}

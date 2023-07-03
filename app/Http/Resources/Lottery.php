<?php
  
namespace App\Http\Resources;
use App\Models\CreditNumber;
use Illuminate\Http\Resources\Json\JsonResource;

class Lottery extends JsonResource
{

    public function toArray($request)
    {
        if (!is_null($this->credit_number)) {
            $cr_no = CreditNumber::where('number', $this->credit_number)->first();
            if ($cr_no) {
                $company_logo = asset('uploads/categories/' . $cr_no->company->logo);
            } else {
                $company_logo = "";
            }
        } else {
            $company_logo = "";
        }
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'random_number' => $this->random_number,
            'qr_code' => is_null($this->qr_code) ? "" : asset('uploads/qrcodes/lotteries/'. $this->qr_code),
            'win_status' => $this->win_status,
            'winning_date' => is_null($this->winning_date) ? "" : date('d-m-Y', strtotime($this->winning_date)),
            'credit_number' => is_null($this->credit_number) ? "" : $this->credit_number,
            'company_logo' => $company_logo,
            'gift_name' => isset($this->bundle) && isset($this->bundle->name) ? $this->bundle->name : ""
        ];
    }
    
}
<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Twilio\Rest\Client;
use Validator;
use App\Models\User;
use Hash;
class UserController extends BaseController
{
    

    # form data for Signup 
    # email,password,confirm_password
    #url http://localhost/boiler/public/api/register
    public function updateProfile($id, Request $request)
    {
        $user=User::where('id',$id)->first();
        $user->full_name = $request->full_name;
        $user->email = $request->email;
        $user->city = $request->city;
        $user->location = $request->location;
        $user->dob = $request->dob;
        if($user->save()){
          $success['user']= $user;
          return $this->sendResponse($success, 'Profile udpated successfully.');
        }
        else{
            return ['message'=>'ERROR invalid inputs'];
        }
    }

    public function isActiveUser(Request $request)
    {
        $user = User::where('phone', $request->phone)->first();
        if(!$user)
        {
            $arr = array("success" => false, "message" => "User not found");
        }
        else{
            if($user->is_active == '1')
            {
                $arr = array("success" => true, "message" => "Active user", 'active' => $user->is_active);
            }
            else{
                $arr = array("success" => false, "message" => "Inactive user", 'active' => $user->is_active);
            }
            
        }
        return response()->json($arr);
    }

    public function changePassword($id, Request $request){
        $input = $request->all();
        $userid = $id;
        $user = User::where('id', $userid)->first();
        if(!$user)
        {
            $arr = array("success" => false, "message" => "User not found");
        }
        $rules = array(
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $arr = array("success" => false, "message" => $validator->errors()->first());
        } else {
            try {
                if ((Hash::check(request('old_password'), $user->password)) == false) {
                    $arr = array("success" => false, "message" => "Check your old password");
                } else if ((Hash::check(request('new_password'), $user->password)) == true) {
                    $arr = array("success" => false, "message" => "Please enter a password which is not similar then current password");
                } else {
                    User::where('id', $userid)->update(['password' => Hash::make($input['new_password'])]);
                    $arr = array("success" => true, "message" => "Password updated successfully");
                }
            } catch (\Exception $ex) {
                if (isset($ex->errorInfo[2])) {
                    $msg = $ex->errorInfo[2];
                } else {
                    $msg = $ex->getMessage();
                }
                $arr = array("success" => false, "message" => $msg);
            }
        }
        return response()->json($arr);
    }

    public function addFullNames()
    {
        $users = User::all();
        foreach($users as $user)
        {
            $user->full_name = $user->first_name;
            if($user->sur_name != "")
            {
                $user->full_name .= ' '. $user->sur_name;
            }
            $user->save();
        }
    }

    public function sendCodeAgain(Request $request)
    {
        $identifier = $request->country_code . $request->phone;
        $otp = generateSms($identifier, 6, 2);
        if(isset($otp->token) && $otp->token != '')
        {
            $message = 'Your Otp code is ' . $otp->token;
            $recipient = '+'.$identifier;
            $response = sendVerificationSms($message, $recipient);
            return response()->json(['success' => true, 'status' => 200, 'message' => 'code sent successfully']);
        }
        else{
            return response()->json(['success' => true, 'status' => 500, 'message' => 'Please try again']);
        }
    }

    public function verifyOtp(Request $request)
    {
        $identifier = $request->country_code . $request->phone;
        $final_phone = '00'.$request->country_code . $request->phone;
        $validate = validateSms($identifier, $request->code);
        if(isset($validate->status) && $validate->status)
        {
            if(isset($request->type) && $request->type == 'register')
            User::where('phone', $final_phone)->update(['is_active', 1]);
            return response()->json(['status' => 200, 'success' => true, 'message' => 'OTP is valid', 'type' => isset($request->type) ? $request->type : 'forget-password']);
        }
        else{
            return response()->json(['status' => 500, 'success' => true, 'message' => $validate->message, 'type' => $request->type]);
        }
    }
    

    public function verifyAccount(Request $request)
    {
        $data = $request->validate([
            'verification_code' => ['required', 'numeric'],
            'phone_number' => ['required', 'string'],
        ]);
        /* Get credentials from .env */
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        $twilio = new Client($twilio_sid, $token);
        $verification = $twilio->verify->v2->services($twilio_verify_sid)
            ->verificationChecks
            ->create($data['verification_code'], array('to' => $data['phone_number']));
        if ($verification->valid) {
            $user = tap(User::where('phone_number', $data['phone_number']))->update(['isVerified' => true]);
            /* Authenticate user */
            Auth::login($user->first());
            return redirect()->route('home')->with(['message' => 'Phone number verified']);
        }
        return response()->json(['status' => 500, 'success' => true, 'phone_number' => $data['phone_number'], 'error' => 'Invalid verification code entered!']);
    }
   
}
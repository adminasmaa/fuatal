<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\User;
use App\Models\City;
use Hash;
class AuthController extends BaseController
{
    # form data for this
     
    # email,password

    #url http://localhost/fustekaicecream/public/api/login

    public function signin(Request $request)
    {

        if($request->type == 'email'){

            $data='email';
        } 
        else{
            
            $data='phone';
        }   
       
        if(Auth::attempt([$data => $request->email, 'password' => $request->password])){ 
            $authUser = Auth::user(); 

            $success['token'] =  $authUser->createToken('MyAuthApp')->accessToken;
            $success['user']= $authUser;
            $status=$authUser->is_active;
            if($status==0){
                return response()->json(['success'=>false,'message'=>'Inactive user']);
            }
            else{
            //$success['name'] =  $authUser->name;
            return $this->sendResponse($success, 'User signed in');
            }

        }        
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }

    # form data for Signup 
    # email,password,confirm_password
    #url http://localhost/boiler/public/api/register
    public function signup(Request $request)
    {
        /*$phone=$request->get("phone");
        $str = $phone;
        echo $str[0];  
        exit;*/
        $phone=$request->get("phone");
        $country_code=$request->get("country_code");
        //$str = $phone;
        //echo $str[0];
        if($phone[0]=='0'){
            $phone=ltrim($phone, $phone[0]);
        } 


        $finalPhone='00'.$country_code.''.$phone;
        $requestData = $request->all();
        $requestData['phone'] = $finalPhone;
        $validator = Validator::make($requestData, [
            //'name' => 'required',
            //'email', 'unique:users,email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'full_name'=>'required',
            //'sur_name'=>'required',
            'country'=>'required',
            //'city'=>'required',
            'phone'=>'required',
            // 'phone'=>'required|unique:users,phone',
            'country_code'=>'required',
            'gender'=>'required',
            'location'=>'required',      
        ]);
        // $checkUser=User::where('email',$request->email)->first();
       /* if(!is_null($checkUser)){
            return response()->json(['success'=>false,'message'=>'Email already exist!']);
        }*/
        
        if($validator->fails()){
            return response()->json(['success'=>false,'message'=>'The Phone has already been taken', 'data' => []]);
        }

        


        $email=$request->email;

        $dob=$request->dob;

        $sur_name=$request->sur_name;

        $city=$request->city;
    
        $input = $request->all();
        $password=$input['password'];
        //$user = User::create($input);
        // $otp = generateOtp($country_code . $phone, 6, 2);
        // if(isset($otp->token) && $otp->token != '')
        // {
        //     $message = 'Your Otp code is ' . $otp->token;
        //     $recipient = '+'.$country_code.$phone;
        //     $response = sendVerificationCode($message, $recipient);
        // }
        $userobj=new User;
        $userobj->email=$email;
        $userobj->password= $password;
        $userobj->full_name =$request->get("full_name");
        $userobj->dob = $dob;
        $userobj->gender =$request->get("gender");
        $userobj->phone =$finalPhone;
        $userobj->country=$request->get("country");
        $userobj->city=$city;
        $userobj->country_code=$request->country_code;
        $userobj->location=$request->get("location");
        
      
        if($userobj->save()){ 

          $success['token'] = $userobj->createToken('MyAuthApp')->accessToken;
          
          return $this->sendResponse($success, 'User created successfully.');
        } 
        else{
            return ['message'=>'ERROR invalid inputs'];
        }
    }




    public function saveUserStatus(Request $request)
    {


        $phone=$request->phone;
        //$phone="00".$str;
        $objUser=User::where('phone',$phone)->first();
          

        //$objUser=User::where('email',$request->email)->first();

        if($objUser){

         User::where('phone',$request->phone)->update(['is_active'=>1, 'activated_by_otp' => 1]);
              

        return response()->json(['success'=>true,'message'=>'Record updated!']);
        }

        else{
       
            return response()->json(['success'=>false,'message'=>'Invalid user']);

        }
    }
    
    # Params  no
    # set Bearer token that was generated at login time
    #url http://localhost/boiler/public/api/logout
    public function logout(Request $request)
    {
        
        auth()->user()->tokens()->delete();
         return [
        'message' => 'Logged out'
         ];
    }

public function forgotPassword(Request $request)
{
    $input = $request->all();
    $rules = array(
        'phone' => "required",
        'password' => "required",
    );
    $validator = Validator::make($input, $rules);
    if ($validator->fails()) {
        $arr = array("success" => false, "message" => $validator->errors()->first());
    } else {
        $user = User::where('phone', $request->phone)->first();
        if($user)
        {
            User::where('phone', $request->phone)->update(['password' => Hash::make($request->password)]);
            $arr = array("success" => true, "message" => "password changed successfully");
        }
        else{
            $arr = array("success" => false, "message" => "user not found for this phone number");
        }
    }
    return response()->json($arr);
}


    public function getCities(Request $request)
    {
        
        if(isset($_GET['lang_name'])){

          $lang_name=$_GET['lang_name'];
          if($lang_name=='ar'){
            $lang_name='Arabic';
          }
          else{
            $lang_name='English';
          }
          $data=City::where('lang_name',$lang_name)->get();

        }
        else{
            $data=City::where('lang_name','English')->get();
        }  

        
        //return $data;

        return response()->json([
                    "success"=> true,
                    "data"=> $data,
                    "message"=>"Data Fetched!"
                  ]);
       
    }
   
}
<?php
use App\Models\Otp;
use Twilio\Rest\Client;
use Illuminate\Support\Carbon;

     /**
     * @param string $identifier
     * @param int $digits
     * @param int $validity
     * @return mixed
     */
    if(!function_exists('generateOtp'))
    {
        function generateOtp(string $identifier, int $digits = 4, int $validity = 10) : object
        {
            Otp::where('identifier', $identifier)->where('valid', true)->delete();

            $token = str_pad(generatePin($digits), $digits, '0', STR_PAD_LEFT);

            // if ($digits == 5)
            //     $token = str_pad(generatePin(5), 5, '0', STR_PAD_LEFT);

            // if ($digits == 6)
            //     $token = str_pad(generatePin(6), 6, '0', STR_PAD_LEFT);

                Otp::create([
                'identifier' => $identifier,
                'token' => $token,
                'validity' => $validity
            ]);

            return (object)[
                'status' => true,
                'token' => $token,
                'message' => 'OTP generated'
            ];
        }
    }
    /**
     * @param string $identifier
     * @param string $token
     * @return mixed
     */
    if(!function_exists('validateOtp'))
    {
        function validateOtp(string $identifier, string $token) : object
        {
            $otp = Otp::where('identifier', $identifier)->where('token', $token)->first();

            if ($otp == null) {
                return (object)[
                    'status' => false,
                    'message' => 'OTP does not exist'
                ];
            } else {
                if ($otp->valid == true) {
                    $carbon = new Carbon;
                    $now = $carbon->now();
                    $validity = $otp->created_at->addMinutes($otp->validity);

                    if (strtotime($validity) < strtotime($now)) {
                        $otp->valid = false;
                        $otp->save();

                        return (object)[
                            'status' => false,
                            'message' => 'OTP Expired'
                        ];
                    } else {
                        $otp->valid = false;
                        $otp->save();

                        return (object)[
                            'status' => true,
                            'message' => 'OTP is valid'
                        ];
                    }
                } else {
                    return (object)[
                        'status' => false,
                        'message' => 'OTP is not valid'
                    ];
                }
            }
        }
    }
    /**
     * @param int $digits
     * @return string
     */
    if(!function_exists('generatePin'))
    {
        function generatePin($digits = 4)
        {
            $i = 0;
            $pin = "";

            while ($i < $digits) {
                $pin .= mt_rand(0, 9);
                $i++;
            }

            return $pin;
        }
    }

    if(!function_exists('sendVerificationCode'))
    {
        function sendVerificationCode($message = "", $recipients = "") : object
        {
            $token = getenv("TWILIO_AUTH_TOKEN");
            $twilio_sid = getenv("TWILIO_SID");
            $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
            $twilio = new Client($twilio_sid, $token);
            try{
                $message = $twilio->messages 
                    ->create($recipients, // to 
                            array(  
                                "messagingServiceSid" => getenv("TWILIO_MESSAGE_ID"),      
                                "body" => $message 
                            ) 
                    );
            }
            catch(Exception $e)
            {
                return response()->json(['message' => $e->getMessage()], 500);
            }
            return (object)[
                'status' => 200,
                'success' => true,
                'message' => 'Code is sent to your phone number'
            ];
        }
    }

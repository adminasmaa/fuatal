<?php
use App\Models\Otp;
use Illuminate\Support\Carbon;

     /**
     * @param string $identifier
     * @param int $digits
     * @param int $validity
     * @return mixed
     */
    if(!function_exists('generateSms'))
    {
        function generateSms(string $identifier, int $digits = 4, int $validity = 10) : object
        {
            Otp::where('identifier', $identifier)->where('valid', true)->delete();

            $token = str_pad(generateCode($digits), $digits, '0', STR_PAD_LEFT);

            // if ($digits == 5)
            //     $token = str_pad(generateCode(5), 5, '0', STR_PAD_LEFT);

            // if ($digits == 6)
            //     $token = str_pad(generateCode(6), 6, '0', STR_PAD_LEFT);

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
    if(!function_exists('validateSms'))
    {
        function validateSms(string $identifier, string $token) : object
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
    if(!function_exists('generateCode'))
    {
        function generateCode($digits = 4)
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

    if(!function_exists('sendVerificationSms'))
    {
        function sendVerificationSms($message = "", $recipients = "") : object
        {
            $token = getenv("VONAGE_AUTH_TOKEN");
            $secret = getenv("VONAGE_AUTH_SECRET");
            $basic  = new \Vonage\Client\Credentials\Basic($token, $secret);
            $client = new \Vonage\Client($basic);
            try{
                $response = $client->sms()->send(
                    new \Vonage\SMS\Message\SMS($recipients, 'Fusteka', $message)
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

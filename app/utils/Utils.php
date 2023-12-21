<?php

namespace App\Utils;


use App\Models\Agent;
use App\Models\NewCustomer;
use App\Models\User;
use http\Env\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\Cast\Double;

class Utils
{

    public function validatePin($request, $pinFromDB, $utils): bool
    {
        if (!Hash::check($request->get("pin"), $pinFromDB))
            return false;
        return true;
    }
    public function getBalance($user_id): Double
    {
        return Agent::where("user_id", $user_id)->value("wallet");

    }
    public function checkBalance($role, $user_id, $request): bool
    {
        if ($role == "agent"){
            $balance = Agent::where("user_id", $user_id)->value("wallet");
            if ($balance < $request->get("amount"))
                return false;
            return true;
        }else{
            $balance = NewCustomer::where("user_id", $user_id)->value("wallet");
            if ($balance < $request->get("amount"))
                return false;
            return true;
        }
    }
    /**
     * @param $type
     * @return string
     */
    public static function generateCramp($type) :string
    {
        $mt = explode(' ', microtime());
        $rand = time() . rand(10, 99);
        $time = ((int)$mt[1]) * 1000000 + ((int)round($mt[0] * 1000000));
        $generated = $rand . $time;

        switch ($type) {
            case "agent" :
                return "3060" . $generated;
                break;
            case "customer" :
                return "3061" . $generated;
            default:
                return "3069" . $generated;
                break;
        }
    }
    public function message($msg = "Success", $data, $code): JsonResponse
    {
        return response()->json(["msg" => $msg, "data" => $data], $code);
    }
    public function convertImageToBase64($request, $image): array
    {
        preg_match("/data:image\/(.*?);/",$image,$image_extension); // extract the image extension
        $image = preg_replace('/data:image\/(.*?);base64,/','',$image); // remove the type part
        $image = str_replace(' ', '+', $image);
        $imageName = 'images/image_' . time() . '.' . $image_extension[1]; //generating unique file name;
        return [
                "image" =>  $image,
                "imageName" => $imageName
            ];
    }

    public function uploadImage($imageName, $image)
    {
        $storageSuccess  =  Storage::disk('public')->put($imageName,base64_decode($image));
        if($storageSuccess) {
            return Storage::disk('public')->url($imageName);
        } else {
            return response('Failed to store the image', 500);
        }
    }


    public function sendNotifications($request)
    {
        $firebaseToken = ["dQJlHc_dbfVBHz3zJDZrla:APA91bGQWALdrSeKvY6HRQ1Z1mfT1LpcwkwHsLfUMwxPwBtB7UL4ac7QP_HEJimG6msOLvJLCywBIG7dHY4CGgprutSd_qe_H"];

        $SERVER_API_KEY = env("FIREBASE_SERVER_KEY");

        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $request->get("title"),
                "body" => $request->get("body"),
                "content_available" => true,
                "priority" => "high",
            ]
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);

       return $response;
    }


}

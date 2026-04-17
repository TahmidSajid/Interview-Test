<?php

namespace App\Http\Helpers;




class Response{

    public static function validation($message,$data){
        return response()->json([
            'error'   => true,
            'message' => $message,
            'data'    => $data,
        ],422);
    }

    public static function error($message,$data,$status = 400){
        return response()->json([
            'error'   => true,
            'message' => $message,
            'data'    => $data,
        ],$status);
    }

    public static function success($message,$data,$status = 200){
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ],$status);
    }
}

?>

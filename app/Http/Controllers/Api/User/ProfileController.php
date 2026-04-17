<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Response;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index(){

        $user = User::auth()->first()->only('name','email');

        return Response::success('Profile Fetched Successfuly',$user);
    }

    public function logout(Request $request)
    {

        try {
            $request->user()->token()->revoke();
        } catch (Exception $e) {
            return Response::error('Logout Failed Please try again',[],400);
        }


        return Response::success('Logout Successful',[],200);

    }
}

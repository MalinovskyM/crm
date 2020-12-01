<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LoginController extends BaseController
{
    public function index(Request $request)
    {
        $input = $request->only(["email","password"]);
        $rule = [
            'email' => 'required|email',
            'password' => 'required',
        ];

        $validator = Validator::make($input,$rule);
        if( $validator->fails() ) {
            return $this->sendError('Find error',$validator->errors());
        }

        $user = User::where('email', $input["email"])->first();
        if (! $user || ! Hash::check($request->password, $user->password)) {
            $this->sendError('login','error login',1);
        }

        $token = $user->createToken('token-test')->plainTextToken;

        return $this->sendResponse($token,'userToken');
    }
}

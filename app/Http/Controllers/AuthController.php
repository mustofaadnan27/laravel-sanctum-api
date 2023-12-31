<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\RoleUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
   public function registerUser(Request $request) {

        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5'
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'failed validation',
                'data' => $validator->errors()
            ], 401);
        }

        $userId = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        // dd($userId->id);
        RoleUser::create([
            'user_id' => $userId->id,
            'role_id' => 1
        ]);
       

        return response()->json([
            'status' => true,
            'message' => 'Registration successful',
            'data' => $request->email,
        ], 200);
        

   }


   public function loginUser(Request $request) {

        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|min:5'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'failed validation',
                'data' => $validator->errors()
            ], 401);
        }

        if(!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status' => false,
                'message' => 'failed to login'
            ], 401);
        }
      
        $dataUser = User::where('email', $request->email)->with('roles:id,role_name')->first();
        $result = [];
        $roles = $dataUser->roles;
        // dd($roles);
        if($roles->isEmpty()) {
            $result = ["*"];
        } else {
            foreach ($roles as $role) {
                $result = [$role->role_name];
            }
        }
       
        // dd($dataUser);
        // $role = Role::join("user_role","user_role.role_id","=","roles.id")
        //     ->join("users", "users.id","=","user_role.user_id")->where('user_id', $dataUser->id);
        return response()->json([
            'status' => true,
            'message' => 'success login',
            'token' => $dataUser->createToken('api-product', $result)->plainTextToken
            // 'token' => $dataUser->createToken('api-product', ['product-list])->plainTextToken
        ], 200);

   }
}

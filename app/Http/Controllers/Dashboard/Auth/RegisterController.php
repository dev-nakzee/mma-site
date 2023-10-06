<?php

namespace App\Http\Controllers\Dashboard\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use App\Models\User;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function register(Request $request): JsonResponse
    {
        //
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:'.User::Class],
            'password' => ['required', Rules\Password::defaults()],
        ]);
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()]);
        }
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ];
        if(!User::create($data)){ 
            return response()->json(['error' => 'Something went wrong! Please try again.'], 422);
        } else {
            if(auth()->guard('user')->attempt(['email' => $request->email, 'password' => $request->password])){
                config(['auth.guards.api.provider' => 'user']);         
                $user = User::select('users.*')->find(auth()->guard('user')->user()->id);
                $success =  $user;
                $success['token'] =  $user->createToken('MMA',['user'])->accessToken; 
                return response()->json($success, 200);
            } else { 
                return response()->json(['error' => ['Something went wrong but you are registered.']], 200);
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

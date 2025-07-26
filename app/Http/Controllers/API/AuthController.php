<?php
     namespace App\Http\Controllers\API;

     use App\Http\Controllers\Controller;
     use App\Models\User;
     use Illuminate\Http\Request;
     use Illuminate\Support\Facades\Hash;
     use Illuminate\Support\Facades\Validator;
     use Laravel\Sanctum\PersonalAccessToken;

     class AuthController extends Controller
     {
         public function register(Request $request)
         {
             $validator = Validator::make($request->all(), [
                 'name' => 'required|string|max:255',
                 'email' => 'required|string|email|max:255|unique:users',
                 'password' => 'required|string|min:8|confirmed',
             ]);

             if ($validator->fails()) {
                 return response()->json(['errors' => $validator->errors()], 422);
             }

             $user = User::create([
                 'name' => $request->name,
                 'email' => $request->email,
                 'password' => Hash::make($request->password),
             ]);

             $token = $user->createToken('auth_token')->plainTextToken;

             return response()->json(['user' => $user, 'token' => $token], 200);
         }

         public function login(Request $request)
         {
             $validator = Validator::make($request->all(), [
                 'email' => 'required|string|email',
                 'password' => 'required|string',
             ]);

             if ($validator->fails()) {
                 return response()->json(['errors' => $validator->errors()], 422);
             }

             if (!auth()->attempt($request->only('email', 'password'))) {
                 return response()->json(['message' => 'Invalid credentials'], 401);
             }

             $user = auth()->user();
             $token = $user->createToken('auth_token')->plainTextToken;

             return response()->json(['user' => $user, 'token' => $token], 200);
         }

         public function logout(Request $request)
         {
             $request->user()->currentAccessToken()->delete();

             return response()->json(['message' => 'Logged out successfully'], 200);
         }
     }

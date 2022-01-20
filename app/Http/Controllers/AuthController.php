<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
 
class AuthController extends Controller {
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login']]);
    }
 
    public function login(Request $request) {
        $credentials = $request->only(['email', 'password']);
        $token = auth('api')->attempt($credentials);
        $user = User::where('email', $request->email)->select(['id', 'name', 'email', 'active'])->first();

        if (!$token || $user->active === 'N') {
            return response()->json(['error' => 'Credenciais Inválidas'], 401);
        }

        $response = [
            'token' => $token,
            'user' => $user,
        ];

        return $this->respondWithToken($response);
    }

    public function me() {
        return response()->json(auth('api')->user());
    }
 
    public function logout() {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
 
    public function refresh() {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token) {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
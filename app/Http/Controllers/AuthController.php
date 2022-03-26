<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\PerfilPermissao;
use App\Models\User;
use App\Repository\Eloquent\PerfilPermissaoRepository;
use Illuminate\Http\Request;
 
class AuthController extends Controller {
    protected $perfilPermissiaoRepository;

    public function __construct(PerfilPermissaoRepository $perfilPermissaoRepository) {
        $this->middleware('auth:api', ['except' => ['login']]);

        $this->perfilPermissiaoRepository = $perfilPermissaoRepository; 
    }
 
    public function login(Request $request) {
        $credentials = $request->only(['email', 'password']);
        $token = auth('api')->attempt($credentials);
        $user = User::where('email', $request->email)->select(['id', 'name', 'email', 'active', 'perfil_id'])->first();
    
        $permissions = $this->perfilPermissiaoRepository->getPermissoesByPerfil($user->perfil_id, []);

        if (!$token || $user->active === 'N') {
            return response()->json(['error' => 'Credenciais Inválidas'], 401);
        }

        $response = [
            'access_token' => $token,
            'user' => $user,
            'permissions' => $permissions
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

    protected function respondWithToken($data) {
        return response()->json([
            $data
        ]);
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\MessageBag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class ApiTokenController extends Controller
{
    /**
     * Update the authenticated user's API token.
     *
     * @param Request $request
     * @return User|array|MessageBag
     */
    public function login(Request $request)
    {
        $this->validate(['email', 'password']);
        $user = $this->authenticate($request->all());
        
        if ( time() > strtotime($user->expiration_account) ){
            throw response("Conta expirada, por favor entrar em contato com o suporte.", 401);
        }

        $user->update(['api_token' => bcrypt(Str::random(60))]);
        return $user;
    }

    public function me(Request $request)
    {
        try
        {
            $token = $request->only("api_token");
            $user = User::where('api_token', $token)->first();
            
            if ( time() > strtotime($user->expiration_account) ){
                throw response("Conta expirada, por favor entrar em contato com o suporte.", 401);
            }
            return $user;
        } catch (ValidationException $e) {
            return $e->validator->errors();
        }
    }


    /**
     * Tenta autenticar o usuario com as credenciais
     *
     * @param array $credentials dados de login do usuario
     * @return User
     *
     * @throws UnauthorizedHttpException
     */
    public function authenticate(array $credentials)
    {
        $user = User::auth($credentials['email'], $credentials['password']);

        if ($user) {
            return $user;
        }

        throw new UnauthorizedHttpException('Not authorized!');
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use App\Notifications\SignupActivate;

class AuthController extends Controller
{
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] username
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);

        $user = new User([
            'name' => $request->name,
            'username' => str_slug($request->name, ''),
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'activation_token' => str_random(60)
        ]);

        $user->save();

        $avatar = \Avatar::create($user->name)->getImageObject()->encode('png');
        \Storage::put('avatars/'.$user->id.'/avatar.png', (string) $avatar);

        $user->notify(new SignupActivate($user));

        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = request(['email', 'password']);
        $credentials['active'] = 1;
        $credentials['deleted_at'] = null;

        if(!\Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);

        $user = $request->user();

        if (!$user->api_token){
//             Creating a token with scopes...
//            $tokenResult = $user->createToken('LaraAuth Personal Access Client', ['authentication'])->accessToken;
//             Creating a token without scopes...
            $tokenResult = $user->createToken('LaraAuth Personal Access Client');

            $token = $tokenResult->token;

            if ($request->remember_me)
                $token->expires_at = Carbon::now()->addWeeks(4);

            $token->save();

            $user->api_token = $tokenResult->accessToken;
            $user->save();
        }

        return response()->json([
            'access_token' => $user->api_token,
            'token_type' => 'Bearer',
            'api_token' => 'Bearer '.$user->api_token,
//            'expires_at' => Carbon::parse(
//                $tokenResult->token->expires_at
//            )->toDateTimeString()
        ]);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function AuthUser(Request $request)
    {
//        $AuthID = Auth::user();
//        return json_decode((string) $AuthID, true);
        return response()->json($request->user());
    }

    /**
     * Activate User
     *
     */
    public function signupActivate($token)
    {
        $user = User::where('activation_token', $token)->first();

        if (!$user) {
//            return response()->json([
//                'message' => 'This activation token is invalid.'
//            ], 404);
            return redirect()->route('activate-error');
        }

        $user->active = true;
        $user->activation_token = '';
        $user->email_verified_at = Carbon::now();
        $user->save();

//        return $user;
        return redirect()->route('activate-success', ['user' => $user->name, 'email' => $user->email]);
    }

}

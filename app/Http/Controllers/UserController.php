<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ApiController;
use Faker\Core\Number;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Type\Integer;

class UserController extends Controller
{
    private function issueToken(User $user)
    {

        $userToken = $user->token() ?? $user->createToken('socialLogin');

        return [
            "token_type" => "Bearer",
            "accessToken" => $userToken->accessToken,
        ];
    }

    /**
     * Create a new user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request) {
        $data = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:255',
            'username' => 'required|string|min:3|max:32|alpha_dash|regex:/^[a-zA-Z0-9]+([._]?[a-zA-Z0-9]+)*$/u|unique:users',
            'password' => 'required|string|min:6',
            'bio' => 'string',
            'email' => 'required|string|email|max:255|unique:users',
        ]);
        if ($data->fails()) {
            return (new ApiController())->ApiCreator($data->errors()->all(), true);
        } else {
            $user = new User();
            $user->name = $request->name;
            $user->username = $request->username;
            $user->password = $request->password;
            $user->email = $request->email;
            $user->bio = $request->bio || '';
            $user->avatar = $request->avatar && strlen($request->avatar) > 0 ? $request->avatar : 'noavatar';
            $user->save();

            $data = $this->issueToken($user);

            return response($data, 200);
        }
    }

    /**
     * Edit user info
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function edit(Request $request) {
        $data = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:255',
            'username' => 'required|string|min:3|max:32|alpha_dash|regex:/^[a-zA-Z0-9]+([._]?[a-zA-Z0-9]+)*$/u|unique:users',
            'password' => 'required|string|min:6',
            'bio' => 'string|min:3',
            'email' => 'required|string|email|max:255|unique:users',
        ]);
        if ($data->fails()) {
            return (new ApiController())->ApiCreator($data->errors()->all(), true);
        } else {
            $user = new User();
            $user->name = $request->name;
            $user->username = $request->username;
            $user->password = $request->password;
            $user->email = $request->email;
            $user->bio = $request->bio || '';
            $user->avatar = $request->avatar && strlen($request->avatar) > 0 ? $request->avatar : 'noavatar';
            $user->save();

            $data = $this->issueToken($user);

            return response($data, 200);
        }
    }

    /**
     * Login with email
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|JsonResponse|\Illuminate\Http\Response
     */
    public function login(Request $request) {
        $prefix = '';
        if ($request->username) {
            $validator = Validator::make($request->all(), [
                'username' => 'required|string|min:3|max:32',
                'password' => 'required|string|min:6',
            ]);
            $user = User::where('username', $request->username)->first();
        } else {
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:6',
            ]);
            $user = User::where('email', $request->email)->first();
        }
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Chat App Grant Client');
                $response = ['accessToken' => $token->accessToken ];
                return response($response, 200);
            } else {
                return (new ApiController())->ApiCreator(['success' => false, "message" => "Password mismatch"], true);
            }
        } else {
            return (new ApiController())->ApiCreator(['success' => false, "message" => "User does not exist"], true);
        }
    }

    /**
     * Get User By Username
     *
     * @param String $username
     * @return JsonResponse
     */
    public function getUserByUn(string $username) {
        $users = User::where('username','like', $username . '%')->get();
        if (count($users) === 0) {
            return (new ApiController())->ApiCreator('User not found!', true);
        }
        return (new ApiController())->ApiCreator($users);
    }

    /**
     * Get User By Id
     *
     * @param int $id
     * @return JsonResponse
     */
    public function getUserById(int $id) {
        $user = User::find($id);
        if (!$user) {
            return (new ApiController())->ApiCreator('User not found!', true);
        }
        return (new ApiController())->ApiCreator($user);
    }


    /**
     * Returns authenticated user's data.
     *
     * @return JsonResponse
     */
    public function me() {
        return (new ApiController())->ApiCreator(auth()->user());
    }


    /**
     * Log the user out of the application.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return (new ApiController())->ApiCreator(['success' => true]);
    }
}

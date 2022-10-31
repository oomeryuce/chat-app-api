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
        $update = User::find(auth()->id());
        if ($update->username !== $request->username){
            $data = Validator::make($request->all(), [
                'name' => 'required|string|min:3|max:255',
                'username' => 'required|string|min:3|max:32|alpha_dash|regex:/^[a-zA-Z0-9]+([._]?[a-zA-Z0-9]+)*$/u|unique:users',
                'bio' => 'string|min:3',
            ]);
        }else {
            $data = Validator::make($request->all(), [
                'name' => 'required|string|min:3|max:255',
                'bio' => 'string|min:3',
            ]);
        }
        if ($data->fails()) {
            return (new ApiController())->ApiCreator($data->errors()->all(), true);
        } else {
            $update->name = $request->name;
            if ($update->username !== $request->username){
                $update->username = $request->username;
            }
            $update->bio = $request->bio;
            // $user->avatar = $request->avatar && strlen($request->avatar) > 0 ? $request->avatar : 'noavatar';
            $update->save();

            return (new ApiController())->ApiCreator($update);
        }
    }

    /**
     * Update password
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function passwordReset(Request $request): JsonResponse
    {
        $user = \auth();
        $password = User::find($user->id());
        $data = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'confirmed|min:6|different:oldPassword',
            'password_confirmation' => 'required_with:password|same:password',
        ]);
        if ($data->fails())
        {
            return (new ApiController())->ApiCreator($data->errors()->all(), true);
        }

        if (Hash::check($request->old_password, $password->password)) {
            $update = User::where('id', $user->id())->update(['password' => bcrypt($request->password)]);
            return (new ApiController())->ApiCreator(['success' => 'true']);
        } else {
            return (new ApiController())->ApiCreator(["Old password does not match."], true);
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
        $user = User::where('username', $username)->first();
        if (is_null($user)) {
            return (new ApiController())->ApiCreator('User not found!', true);
        }
        return (new ApiController())->ApiCreator($user);
    }

    /**
     * Get User By Username
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function searchUser(Request $request) {
        $validator = Validator::make($request->all(), [
            'searchKey' => 'required|string|min:3|max:50',
        ]);if ($validator->fails()) {
            return (new ApiController())->ApiCreator($validator->errors()->all(), true);
        } else {
            $users = User::where(function ($query) use($request){
                    $query->where('username', 'like', '%' . $request->searchKey . '%')
                        ->orWhere('name', 'like', '%' . $request->searchKey . '%');
                })
                ->where('id', '!=', $request->user()->id)
                ->limit(20)
                ->get();
            if (count($users) === 0) {
                return (new ApiController())->ApiCreator('No any users found!', true);
            }
            return (new ApiController())->ApiCreator($users);
        }
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

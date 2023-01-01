<?php

namespace App\Http\Controllers\Api;


use App\Components\Tinypng\TinypngComponent;
use App\Helper\TokenHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\NotFoundResource;
use App\Http\Resources\TokenExpireResource;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserValidationErrorsResource;
use App\Http\Resources\Users\UserExistResource;
use App\Http\Resources\Users\UsersRegistrationResource;
use App\Http\Resources\Users\UsersResource;
use App\Http\Resources\Users\UsersValidationErrorsResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class UsersApiController extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'page' => 'required|integer|min:1',
            'count' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return new UsersValidationErrorsResource($validator->errors());
        }

        $users = User::paginate($request->get('count'), ['*'], 'page', $request->get('page'));

        if ($users->isEmpty()) {
            return new NotFoundResource('Page not found');
        }

        return new UsersResource($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:2|max:60',
            'last_name' => 'required|min:2|max:60',
            'gender' => 'required|in:Male,Female',
            'email' => ['required', 'min:2', 'max:100', 'regex:/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD'],
            'phone' => 'required|regex:/^\+(380)[0-9]{9}$/',
            'photo' => 'required|image|mimes:jpeg,jpg|max:5120',
            'position_id' => 'required|integer|exists:positions,id',
            'remember_token' => 'required|string',
        ]);

        if ($validator->fails()) {
            return new UsersValidationErrorsResource($validator->errors());
        }

        if (User::where('email', $request->get('email'))
            ->orWhere('phone', $request->get('phone'))->first()) {

            return new UserExistResource('User with this phone or email already exist');
        }

        if (!(new TokenHelper())->decryptToken($request->get('remember_token'))) {
            return new TokenExpireResource('The token expired.');
        }

        if (!User::where('email', $request->get('email'))->first()) {
            $user = DB::transaction(function () use ($request) {
                $photo = $request->file('photo');

                $tinify = new TinypngComponent($photo->path());
                $tinify->optimizeImage();

                $tinify->source->toFile(storage_path('app/images/' . $tinify->fileName()));
                $imagePath = Storage::disk('images')->path($tinify->fileName);

                $user = new User();
                $user->first_name = ucfirst($request->get('first_name'));
                $user->last_name = ucfirst($request->get('last_name'));
                $user->gender = ucfirst($request->get('gender'));
                $user->email = $request->get('email');
                $user->phone = $request->get('phone');
                $user->photo = $imagePath;
                $user->position_id = (int)$request->get('position_id');
                $user->remember_token = $request->get('remember_token');
                $user->save();

                return $user;
            });

            return new UsersRegistrationResource($user);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     */
    public function show($id)
    {
        $user = User::where('id', $id)->first();

        if (!is_numeric($id)) {
            return new UserValidationErrorsResource('Validation failed');
        }

        if (is_null($user)) {
            return new NotFoundResource('The user with the requested identifier does not exist');
        }

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update($request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

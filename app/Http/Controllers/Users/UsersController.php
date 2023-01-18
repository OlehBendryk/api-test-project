<?php

namespace App\Http\Controllers\Users;


use App\Components\TinyPng\TinypngComponent;
use App\Helper\TokenHelper;
use App\Http\Controllers\Controller;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(6);

        return view('users.index')
            ->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $positions = Position::pluck('name', 'id');

        $token = (new TokenHelper())->getRegistrationToken();

        return view('users.create')
            ->with('positions', $positions)
            ->with('token', $token);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
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
            'token' => 'required|string',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        if (!(new TokenHelper())->decryptToken($request->get('token'))) {
            return redirect()->route('users.create')
                ->with('error', "Your token is not correct");
        }
        if (User::where('email', $request->get('email'))
            ->orWhere('remember_token', $request->get('token'))->first()) {
            return redirect()->route('users.create')
                ->with('error', "Such user exist");
        }
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
            $user->remember_token = $request->get('token');
            $user->save();

            return $user;
        });

        return redirect()->route('users.show', $user)
            ->with('success', "User {$user->first_name} {$user->last_name} was registered");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', $user)
            ->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        dd('edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        if (!$user->id) {
            return redirect()->route('users.index')
                ->with('error', "There is not such user");
        }

        $user->delete();

        return redirect()->route('users.index');
    }
}

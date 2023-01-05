<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Traits\HasImage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Mail\RegistrationConfirmationMail;

class UserController extends Controller
{
    use HasImage;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): Response
    {
        if (Auth::user()->isNutritionist()) {
            $patients = Auth::user()->nutritionist->patients()->get();

            return response($patients, Response::HTTP_OK);
        }

        return response('unauthorized', Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'date_of_birth' => $request->date_of_birth,
            'identifier' => $request->identifier,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($request->account_type === 'patient') {
            $user->patient->create([
                'nutritionist_id' => auth()->id(),
                'weight' => $request->weight,
                'height' => $request->height,
                'genre' => $request->genre,
                'psychical_activity' => $request->psychical_activity,
                'caloric_requirement' => $request->caloric_requirement,
                'waist_size' => $request->waist_size,
                'legs_size' => $request->legs_size,
                'wrist_size' => $request->wrist_size,
            ]);
        }

        if ($request->account_type === 'nutritionist') {
            $user->nutritionist->create([]);
        }

        Mail::to($user->email)
            ->send(new RegistrationConfirmationMail([
                'full_name' => $user->fullName(),
                'token' => Str::random(64)
            ]));

        return response('created', Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response($user, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateUserRequest  $request
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'identifier' => $request->identifier,
            'email' => $request->email,
            'password' => $request->password,
            'name' => $request->name,
        ]);

        $user->patient->update([
            'weight' => $request->weight,
            'height' => $request->height,
            'date_of_birth' => $request->date_of_birth,
            'genre' => $request->genre,
            'psychical_activity' => $request->psychical_activity,
            'caloric_requirement' => $request->caloric_requirement,
            'waist_size' => $request->waist_size,
            'legs_size' => $request->legs_size,
            'wrist_size' => $request->wrist_size,
        ]);

        if ($this->isValidImage($request->avatar)) {
            $this->saveImage($user, 'avatar', $request->avatar);
        }

        return response($user, Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();

        return response('deleted', Response::HTTP_OK);
    }

    /**
     * Retrieves current logged user
     *
     * @return Response
     */
    public function me(): Response
    {
        $user = Auth::user();

        return response($user, Response::HTTP_OK);
    }
}

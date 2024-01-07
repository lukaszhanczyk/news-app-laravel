<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = array_filter($request->validated());

        /* @var User $user*/
        $user = User::query()->find($request->user()->id);

        if (isset($data['password'])){
            $data['password'] = bcrypt($data['password']);
        }
        $user->update($data);

        $user->apiSources()->detach();
        $user->sources()->detach();
        $user->categories()->detach();
        $user->authors()->detach();

        if (isset($data['api'])){
            foreach ($data['api'] as $id){
                $user->apiSources()->attach($id);
            }
        }

        if (isset($data['source'])){
            foreach ($data['source'] as $id){
                $user->sources()->attach($id);
            }
        }

        if (isset($data['category'])){
            foreach ($data['category'] as $id){
                $user->categories()->attach($id);
            }
        }

        if (isset($data['author'])){
            foreach ($data['author'] as $id){
                $user->authors()->attach($id);
            }
        }

        return new UserResource($user);

    }


    public function user(Request $request)
    {
        return new UserResource(
            User::query()->find($request->user()->id)
        );
    }


}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserIndexRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\UserIndexResource;
use App\Models\User;
use App\Services\TinypngAPIService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private $tinypngAPIService;
    public function __construct()
    {
        $this->tinypngAPIService = app(TinypngAPIService::class);
    }
	public function index(UserIndexRequest $request)
	{
        $users = User::query()->paginate($request->count);
        if (count(UserIndexResource::collection($users)->resolve())) {
            return response()->json([
                'success' => true,
                'page' => $users->currentPage(),
                'total_pages' => $users->lastPage(),
                'total_users' => $users->total(),
                'count' => $users->perPage(),
                'links' => [
                    'next_url' => $users->nextPageUrl(),
                    'prev_url' => $users->previousPageUrl(),
                ],
                'users' => UserIndexResource::collection($users)->resolve()
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Page not found',
            ], 404);
        }
	}

    public function store(UserStoreRequest $request)
    {
        $data = $request->validated();
        $photoPath = $this->tinypngAPIService->optimizeImage($request->photo);
        $data['photo'] = $photoPath;
        $data['password'] = Hash::make('password');
        $user = User::create($data);

        return response()->json([
            'success' => true,
            'user_id' => $user->id,
            'message' => 'New user successfully registered'
        ]);
    }

    public function show($id)
    {
        $user = User::find($id);

        if ($user) {
            return response()->json([
                'success' => true,
                'user' => new UserIndexResource($user)
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);
        }

    }
}

<?php

namespace Modules\User\Services;

use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Modules\User\Repositories\UserRepository;
use Modules\Configuration\Domain\ConfigDomain;
use Modules\Configuration\Services\SecurityConfigService;
 
class UserService 
{
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    public function register($payload){
        $user = $this->userRepository->createNewUser($payload);

        return response()->json([
            'data' => $user,
            'message' => 'User created successfully'
        ]);
    }

    public function login($payload)
    {
        try {
            JWTAuth::factory()->setTTL(SecurityConfigService::get(ConfigDomain::SESSION_TIMEOUT));
            if (!$token = JWTAuth::attempt($payload)) {
                $this->userRepository->handleAttemps($payload['email']);
                return response()->json([
                	'message' => 'Login credentials are invalid.',
                ], 400);
            }
        } catch (JWTException $e) {
            return response()->json([
                'message' => 'Could not create token.',
            ], 500);
        }

        $user = $this->userRepository->findUser(Auth::id());
        $user->update([
            'login_attempts' => 0, 
            'last_login_at' => Carbon::now()->toDateTimeString()
        ]);

        $ttl = JWTAuth::factory()->getTTL();

        return response()->json([
            'data' => [
                'token' => $token,
                'expires_in' => $ttl * 60,
                'expires_at' => Carbon::now()->addMinutes($ttl)->toDateTimeString(),
                'user' => $user
            ]
        ]);
    }
}
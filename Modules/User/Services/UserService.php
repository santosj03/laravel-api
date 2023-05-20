<?php

namespace Modules\User\Services;

use Carbon\Carbon;
use App\Domain\GenericDomain;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Modules\User\Exceptions\LoginException;
use Modules\User\Repositories\UserRepository;
use Modules\Configuration\Domain\ConfigDomain;
use Modules\Configuration\Services\ConfigurationService;
 
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
            JWTAuth::factory()->setTTL(ConfigurationService::param(ConfigDomain::SESSION_TIMEOUT));
            if (!$token = JWTAuth::attempt($payload)) {
                $this->userRepository->handleAttemps($payload['email']);

                throw new LoginException(GenericDomain::ERR_LOGIN_CRED);
            }
        } catch (JWTException $e) {
            throw new LoginException(GenericDomain::ERR_LOGIN_TOKEN);
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
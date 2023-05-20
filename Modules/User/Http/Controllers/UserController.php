<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\User\Services\UserService;
use Modules\User\Http\Requests\LoginRequest;
use Modules\User\Http\Requests\RegisterRequest;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $service)
    {
        $this->userService = $service;
    }

    public function register(RegisterRequest $request)
    {
        try{
            return $this->userService->register($request->payload());
        }catch(\Exception $ex){
            return response()->json(['message' => $ex->getMessage()], 500);
        }
    }
 
    public function authenticate(LoginRequest $request)
    {
        // try{
            return $this->userService->login($request->payload());
        // }catch(\Exception $ex){
        //     return response()->json(['message' => $ex->getMessage()], 500);
        // }
    }
}

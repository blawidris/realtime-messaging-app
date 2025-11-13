<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Traits\Helper;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use Helper;
    public function __construct(protected UserService $service) {}


    public function index(Request $request)
    {
        $data = $this->service->paginate($request);

        return $this->responseJson(true, $data, 'User result fetched');
    }
}

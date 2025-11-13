<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;

class UserService
{

    public function __construct(protected User $model) {}

    public function paginate(Request $request)
    {
        $perPage = $request->query("per_page", 10);
        $page = $request->query("page", 1);
        $search = $request->query("q");

        $query = User::latest();

        if ($search) {
            $query->selectRaw("");
        }

        $response = $query->paginate($perPage, page: $page);

        return [
            'users' => $response->items(),
            'meta' => [
                "current_page" => $response->currentPage(),
                "last_page" => $response->lastPage(),
                "per_page" => $response->perPage(),
                "total" => $response->total(),
            ]
        ];
    }
}

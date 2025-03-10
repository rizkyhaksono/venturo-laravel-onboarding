<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRoleRequest;
use App\Http\Resources\User\UserRolesResource;
use Illuminate\Http\Request;
use App\Models\UserRolesModel;

class UserRolesController extends Controller
{
    private $userRole;
    public function __construct()
    {
        $this->userRole = new UserRolesModel();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return response()->success([
            'list' => UserRolesResource::collection($this->userRole->paginate($request->per_page ?? 25)),
            'meta' => ['total' => $this->userRole->count()]
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(userRoleRequest $request)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->failed($request->validator->errors());
        }

        $payload = $request->only(['name', 'access']);
        $userRole = $this->userRole->store($payload);

        if (!$userRole) {
            return response()->failed('Gagal menyimpan data user role');
        }

        return response()->success($userRole);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $userRole = $this->userRole->getById($id);

        if (empty($userRole)) {
            return response()->failed('Data user role tidak ditemukan');
        }

        return response()->success($userRole);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(userRoleRequest $request, string $id)
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->failed($request->validator->errors());
        }

        $payload = $request->only(['name', 'access']);
        $userRole = $this->userRole->edit($payload, $id);

        if (!$userRole) {
            return response()->failed('Gagal mengubah data user role');
        }

        return response()->success($userRole);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $userRole = $this->userRole->drop($id);

        if (!$userRole) {
            return response()->failed('Gagal menghapus data user role');
        }

        return response()->success($userRole);
    }
}

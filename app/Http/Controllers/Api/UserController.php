<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use App\Helpers\User\UserHelper;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    private $user;
    public function __construct()
    {
        $this->user = new UserHelper();
    }

    /**
     * Mengambil list user
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     */
    public function index(Request $request)
    {
        $filter = [
            'nama' => $request->nama ?? '',
            'email' => $request->email ?? '',
        ];

        $users = $this->user->getAll($filter, $request->page ?? 1, $request->per_page ?? 25, $request->sort ?? '');

        return response()->success([
            'list' => UserResource::collection($users['data']),
            'meta' => [
                'total' => $users['total']
            ]
        ]);
    }

    /**
     * Membuat data user baru & disimpan ke tabel m_user
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     */
    public function store(userRequest $request)
    {
        /**
         * Menampilkan pesan error ketika validasi gagal
         * pengaturan validasi bisa dilihat pada class app/Http/request/userRequest
         */
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->failed($request->validator->errors());
        }

        $payload = $request->only(['email', 'name', 'password', 'photo']);
        $user = $this->user->create($payload);

        if (!$user['status']) {
            return response()->failed($user['error']);
        }

        return response()->success($user['data']);
    }

    /**
     * Menampilkan user secara spesifik dari tabel m_user
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     */
    public function show($id)
    {
        $user = $this->user->getById($id);

        if (empty($user)) {
            return response()->failed(['Data user tidak ditemukan']);
        }

        return response()->success(new UserResource($user));
    }

    /**
     * Mengubah data user di tabel m_user
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     */
    public function update(userRequest $request)
    {
        /**
         * Menampilkan pesan error ketika validasi gagal
         * pengaturan validasi bisa dilihat pada class app/Http/request/userRequest
         */
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->failed($request->validator->errors());
        }

        // Ensure 'id' exists
        if (!$request->has('id')) {
            return response()->failed(['id' => 'The id field is required.'], 422);
        }

        $payload = $request->only(['id', 'email', 'name', 'password', 'photo']);

        // Fetch user by ID to ensure it exists
        $userData = $this->user->getById($payload['id']);
        if (!$userData['status']) {
            return response()->failed(['message' => 'User not found'], 404);
        }

        $user = $this->user->update($payload, $payload['id']);

        if (!$user['status']) {
            return response()->failed($user['error']);
        }

        return response()->success($user['data']);
    }

    /**
     * Soft delete data user
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     * @param mixed $id
     */
    public function destroy($id)
    {
        $user = $this->user->delete($id);

        if (!$user) {
            return response()->failed(['Mohon maaf data pengguna tidak ditemukan']);
        }

        return response()->success($user);
    }
}

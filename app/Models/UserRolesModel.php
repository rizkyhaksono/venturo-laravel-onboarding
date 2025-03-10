<?php

namespace App\Models;

use App\Repository\CrudInterface;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserRolesModel extends Model implements CrudInterface
{
    use HasFactory;
    use Uuid;
    use SoftDeletes;

    protected $table = "m_user_roles";

    protected $fillable = [
        'name',
        'access',
    ];

    public $timestamp = true;

    public function getAll(array $filter, int $itemPerPage = 0, string $sort = '')
    {
        $userRoles = $this->query();

        if (!empty($filter['name'])) {
            $userRoles->where('name', 'LIKE', '%' . $filter['name'] . '%');
        }

        $sort = $sort ?: 'id DESC';
        $userRoles->orderByRaw($sort);
        $itemPerPage = ($itemPerPage > 0) ? $itemPerPage : false;

        $result = $userRoles->paginate($itemPerPage)->appends('sort', $sort);

        // Pastikan data tidak null
        if (!$result->isEmpty()) {
            return $result;
        }

        return [
            'data' => collect([]), // Pastikan tidak mengembalikan null
            'total' => 0,
        ];
    }

    public function getById(string $id)
    {
        return $this->find($id);
    }

    public function store(array $payload)
    {
        return $this->create($payload);
    }

    public function edit(array $payload, string $id)
    {
        $userRoles = $this->find($id);
        if (empty($userRoles)) {
            return false;
        }

        return $userRoles->update($payload);
    }

    public function drop(string $id)
    {
        return $this->find($id)->delete();
    }
}

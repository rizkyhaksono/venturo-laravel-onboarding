<?php

namespace App\Helpers\UserRole;

use App\Helpers\Venturo;
use App\Models\UserRolesModel;
use Illuminate\Support\Facades\Hash;
use Throwable;

class UserRolesHelper extends Venturo
{
  private $userRolesModel;
  public function __construct()
  {
    $this->userRolesModel = new UserRolesModel();
  }

  /**
   * Mengambil data user role dari tabel m_user_roles
   *
   * @param  array $filter
   * $filter['nama'] = string
   * @param integer $itemPerPage jumlah data yang ditampilkan, kosongi jika ingin menampilkan semua data
   * @param string $sort nama kolom untuk melakukan sorting mysql beserta tipenya DESC / ASC
   *
   * @return object
   */
  public function getAll(array $filter, int $itemPerPage = 0, string $sort = ''): array
  {
    $userRoles = $this->userRolesModel->getAll($filter, $itemPerPage, $sort);

    return [
      'status' => true,
      'data' => $userRoles
    ];
  }

  public function getById(string $id): array
  {
    $userRoles = $this->userRolesModel->getById($id);
    if (empty($userRoles)) {
      return [
        'status' => false,
        'data' => null
      ];
    }

    return [
      'status' => true,
      'data' => $userRoles
    ];
  }

  public function create(array $payload): array
  {
    try {
      $userRoles = $this->userRolesModel->store($payload);
      return [
        'status' => true,
        'data' => $userRoles
      ];
    } catch (Throwable $e) {
      return [
        'status' => false,
        'error' => $e->getMessage()
      ];
    }
  }

  public function update(array $payload, string $id): array
  {
    try {
      $userRoles = $this->userRolesModel->edit($payload, $id);
      return [
        'status' => true,
        'data' => $userRoles
      ];
    } catch (Throwable $e) {
      return [
        'status' => false,
        'error' => $e->getMessage()
      ];
    }
  }

  public function delete(string $id): bool
  {
    try {
      $this->userRolesModel->drop($id);
      return true;
    } catch (Throwable $e) {
      return false;
    }
  }
}

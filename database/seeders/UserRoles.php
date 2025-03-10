<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserRoles extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => Str::uuid()->toString(),
                'name' => 'Rizky',
                'access' => 'Akses penuh untuk data pertama.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null,
                'created_by' => Str::uuid()->toString(),
                'updated_by' => Str::uuid()->toString(),
                'deleted_by' => null,
            ],
            [
                'id' => Str::uuid()->toString(),
                'name' => 'Haksono',
                'access' => 'Akses terbatas untuk data kedua.',
                'created_at' => Carbon::now()->subDays(1),
                'updated_at' => Carbon::now()->subDays(1),
                'deleted_at' => null,
                'created_by' => Str::uuid()->toString(),
                'updated_by' => Str::uuid()->toString(),
                'deleted_by' => null,
            ],
            [
                'id' => Str::uuid()->toString(),
                'name' => 'Natee',
                'access' => 'Data yang sudah dihapus.',
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
                'deleted_at' => Carbon::now()->subDays(1),
                'created_by' => Str::uuid()->toString(),
                'updated_by' => Str::uuid()->toString(),
                'deleted_by' => Str::uuid()->toString(),
            ],
        ];

        DB::table('m_user_roles')->insert($data);
    }
}

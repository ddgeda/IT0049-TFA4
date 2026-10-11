<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use RuntimeException;

class AddPasswordToUsers extends Migration
{
    public function up()
    {
        if (! $this->db->tableExists('users')) {
            throw new RuntimeException('The users table must exist before adding password authentication.');
        }

        $hasPassword = $this->db->fieldExists('password', 'users');
        $users       = $this->db->table('users')->get()->getResultArray();
        $initialPassword = env('auth.initialPassword');
        $updates = [];

        foreach ($users as $user) {
            $storedPassword = $user['password'] ?? null;

            if (is_string($storedPassword) && $storedPassword !== '') {
                $passwordInfo = password_get_info($storedPassword);
                if (($passwordInfo['algoName'] ?? 'unknown') !== 'unknown') {
                    continue;
                }

                $plainPassword = $storedPassword;
            } else {
                if (! is_string($initialPassword) || $initialPassword === '') {
                    throw new RuntimeException(
                        'Set auth.initialPassword in .env before migrating users without a password.'
                    );
                }

                $plainPassword = $initialPassword;
            }

            $updates[] = [
                'id'       => $user['id'],
                'password' => password_hash($plainPassword, PASSWORD_DEFAULT),
            ];
        }

        if (! $hasPassword) {
            $this->forge->addColumn('users', [
                'password' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                ],
            ]);
        }

        foreach ($updates as $update) {
            $this->db->table('users')
                ->where('id', $update['id'])
                ->update(['password' => $update['password']]);
        }

        if (! $hasPassword || $users !== []) {
            $this->forge->modifyColumn('users', [
                'password' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => false,
                ],
            ]);
        }
    }

    public function down()
    {
        if ($this->db->tableExists('users') && $this->db->fieldExists('password', 'users')) {
            $this->forge->dropColumn('users', 'password');
        }
    }
}
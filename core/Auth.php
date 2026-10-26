<?php

namespace App\Core;

final class Auth
{
    public function __construct(private Database $database)
    {
    }

    public function check(): bool
    {
        return !empty(Session::get('user'));
    }

    public function user(): ?array
    {
        return Session::get('user');
    }

    public function login(string $username, string $password): bool
    {
        $user = $this->database->fetch(
            'SELECT * FROM users WHERE username = ? AND aktif = 1 LIMIT 1',
            [$username]
        );

        if (!$user || !password_verify($password, $user['password_hash'])) {
            return false;
        }

        Session::set('user', [
            'id' => (int) $user['id'],
            'nama' => $user['nama'],
            'username' => $user['username'],
            'role' => $user['role'],
            'unit_id' => $user['unit_id'],
        ]);

        return true;
    }

    public function logout(): void
    {
        Session::forget('user');
    }

    public function hasRole(string $role): bool
    {
        $user = $this->user();
        return $user !== null && $user['role'] === $role;
    }

    public function hasAnyRole(array $roles): bool
    {
        $user = $this->user();
        if ($user === null) {
            return false;
        }

        return in_array($user['role'], $roles, true);
    }
}

<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class UserService
{
    public function fetchSortedUsers($count = 10)
    {
        $users = [];

        for ($i = 0; $i < $count; $i++) {
            $response = Http::get('https://randomuser.me/api/');
            $user = $response->json()['results'][0];

            $users[] = [
                'name' => $user['name']['title'] . ' ' . $user['name']['first'] . ' ' . $user['name']['last'],
                'phone' => $user['phone'],
                'email' => $user['email'],
                'country' => $user['location']['country'],
            ];
        }

        // Sort users by last name in reverse alphabetical order
        usort($users, function ($a, $b) {
            return strcmp($b['name'], $a['name']);
        });

        return $users;
    }
}

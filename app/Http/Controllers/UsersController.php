<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UsersController extends Controller
{
    public function usersXml(Request $request)
    {
        $sort = $request->query('sort', 'name');
        $count = $request->query('count', 10);

        $users = Http::get("https://randomuser.me/api/", [
            'results' => $count,
        ])->json()['results'];

        // Sort and filter logic here...
        // Example: sort by last name
        usort($users, fn($a, $b) => strcmp($b['name']['last'], $a['name']['last']));

        // Generating XML Response
        $xml = new \SimpleXMLElement('<users/>');

        foreach ($users as $user) {
            $xmlUser = $xml->addChild('user');
            $xmlUser->addChild('name', $user['name']['title'] . ' ' . $user['name']['first'] . ' ' . $user['name']['last']);
            $xmlUser->addChild('phone', $user['phone']);
            $xmlUser->addChild('email', $user['email']);
            $xmlUser->addChild('country', $user['location']['country']);
        }

        return response($xml->asXML(), 200, ['Content-Type' => 'application/xml']);
    }

    public function showUsers()
    {
        return view('users');
    }
}

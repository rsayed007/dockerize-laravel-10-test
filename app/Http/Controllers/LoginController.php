<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function index()
    {
        // $users = User::with('logins')->orderBy('name')
        //     ->paginate(10);

        $users = DB::table('users')
            ->leftJoin('logins', function ($join) {
                $join->on('users.id', '=', 'logins.user_id')
                    ->whereRaw('logins.created_at = (select max(created_at) from logins where user_id = users.id)');
            })
            ->select('users.name', 'users.email', 'logins.ip_address', 'logins.created_at')
            ->orderBy('users.name')
            ->paginate(10);

        return view('logins', compact('users'));
    }
}

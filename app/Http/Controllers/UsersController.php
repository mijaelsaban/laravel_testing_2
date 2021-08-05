<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;

/**
 * Class UsersController
 * @package App\Http\Controllers
 */
class UsersController extends Controller
{
    public function index()
    {
        return User::active()
            ->isAustrian()
            ->get();
    }


    public function update(Request $request, UserDetail $payment)
    {
        //
    }


    public function destroy(UserDetail $payment)
    {
        //
    }
}

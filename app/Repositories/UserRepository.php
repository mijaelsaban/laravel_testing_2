<?php

namespace App\Repositories;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;

final class UserRepository
{
    public function getActiveAustrians()
    {
        return User::active()
            ->isAustrian()
            ->get();
    }

    /**
     * @throws Exception
     */
    public function updateUserDetails(User $user, array $attributes)
    {
        if (!$user->userDetail) {
            throw new Exception('The user does not have user details');
        }

        $user->userDetail()
            ->update($attributes);

        $user->userDetail->save();
    }

    /**
     * @throws Exception
     */
    public function delete(User $user)
    {
        if ($user->userDetail) {
            throw new Exception(sprintf(
                'The user id %s has details. It cannot be deleted',
                $user->id
            ));
        }

        $user->delete();
    }
}

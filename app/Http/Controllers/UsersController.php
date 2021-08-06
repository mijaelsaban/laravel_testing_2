<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDetail;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

/**
 * Class UsersController
 * @package App\Http\Controllers
 */
class UsersController extends Controller
{
    public function index(): Collection
    {
        return User::active()
            ->isAustrian()
            ->get();
    }


    /**
     * @throws ValidationException
     * @throws Exception
     */
    public function update(User $user, Request $request): JsonResponse
    {
        if (!$user->userDetail) {
            throw new Exception('No user details');
        }

        /**
         * Cleaner way using form request
         */
        $request->validate([
            'citizenship_country_id' => 'required|numeric',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone_number' => 'required|numeric',
        ]);

        $user->userDetail()
            ->update(request()->all());
        $user->userDetail->save();

        return response()->json([
            'message' => 'User updated successfully.',
            'previous' => $user,
            'updated' => $user->refresh()
        ]);
    }


    /**
     * @throws Exception
     */
    public function destroy(User $user): JsonResponse
    {
        if ($user->userDetail) {
            throw new Exception(sprintf(
                'The user id %s has details. It cannot be deleted',
                $user->id
            ));
        }

        $user->delete();

        return response()->json([
            'message' => 'The user was deleted successfully',
            'user' => $user
        ]);
    }
}

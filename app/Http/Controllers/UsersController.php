<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UserRequest;
use App\Repositories\UserRepository;
use Illuminate\Validation\ValidationException;

/**
 * Class UsersController
 * @package App\Http\Controllers
 */
class UsersController extends Controller
{
    public function index(UserRepository $userRepository)
    {
        return $userRepository->getActiveAustrians();
    }


    /**
     * @throws ValidationException
     * @throws Exception
     */
    public function update(
        User $user,
        UserRequest $request,
        UserRepository $userRepository
    ): JsonResponse {

        $userRepository->updateUserDetails($user, $request->validated());

        return response()->json([
            'message' => 'User updated successfully.',
            'previous' => $user->userDetail->getOriginal(),
            'updated' => $user->refresh()
        ]);
    }


    /**
     * @throws Exception
     */
    public function destroy(
        User $user,
        UserRepository $userRepository
    ): JsonResponse {
        $userRepository->delete($user);


        return response()->json([
            'message' => 'The user was deleted successfully',
            'user' => $user
        ]);
    }
}

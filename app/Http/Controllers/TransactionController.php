<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Services\TransactionServiceInterface;
use App\Services\TransactionCsvServiceInterface;
use Illuminate\Contracts\Container\BindingResolutionException;

class TransactionController extends Controller
{
    /**
     * @var TransactionServiceInterface
     */
    private $transactionService;

    public function __construct(TransactionServiceInterface $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /**
     * @throws BindingResolutionException
     */
    public function __invoke(TransactionRequest $request): Collection
    {
        $this->getRegistrationStrategy($request);

        return $this->transactionService->getAll();
    }

    /**
     * @param Request $request
     * @throws BindingResolutionException
     */
    public function getRegistrationStrategy(Request $request): void
    {
        if ($request->get('source') === 'csv') {
            app()->bind(TransactionServiceInterface::class, TransactionCsvServiceInterface::class);
            $this->transactionService = app()->make(TransactionServiceInterface::class);
        }
    }
}

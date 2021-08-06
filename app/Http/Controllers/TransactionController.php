<?php

namespace App\Http\Controllers;

use App\Services\TransactionCsvServiceInterface;
use App\Services\TransactionServiceInterface;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
    public function __invoke(Request $request)
    {
        $request->validate([
            'source' => [
                'required',
                Rule::in(['db', 'csv'])
            ]
        ]);

        $this->getRegistrationStrategy($request);

        dd($this->transactionService->getAll());
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

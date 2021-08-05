<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Collective\Html\HtmlFacade;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\Transactions\ImportService;
use Maatwebsite\Excel\Validators\ValidationException;

class TransactionImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function handle(ImportService $transactionImportService): void
    {
        try {
            $transactionImportService->import($this->file);
        } catch (ValidationException $e) {
            if ($e->getMessage()) {
                Storage::append(
                    'public/imported_transactions.html',
                    HtmlFacade::tag(
                        'li',
                        $e->getMessage(),
                        ['class' => 'broadcast alert alert-danger-muted']
                    )
                );
            }

            $this->errors($e);
        }
    }

    /**
     * @param $e
     */
    private function errors($e): void
    {
        Log::info('-----validation exception-----');
        foreach ($e->errors() as $error) {
            $this->logError($error);
        }
        $this->logSuccess();
    }

    private function logSuccess(): void
    {
        Storage::prepend(
            'public/imported_transactions.html',
            HtmlFacade::tag('div', 'Success', ['class' => 'is-success'])
        );
    }

    /**
     * @param $error
     */
    private function logError($error): void
    {
        Storage::append(
            'public/imported_transactions.html',
            HtmlFacade::tag(
                'li',
                implode($error),
                ['class' => 'broadcast alert alert-danger-muted']
            )
        );
    }
}

<?php


namespace App\Services\Transactions;

use App\Models\UserDetail;
use App\Services\Transactions\Stripe\CreateService;
use Collective\Html\HtmlFacade;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Throwable;

class ImportService implements
    ToArray,
    WithHeadingRow,
    WithValidation,
    SkipsOnError
{
    use Importable, SkipsErrors;

    public $tries = 1;
    /**
     * @var CreateService
     */
    private $createService;

    public function __construct(CreateService $createService)
    {
        $this->createService = $createService;
    }

    /**
     * @param array $rows
     */
    public function array(array $rows)
    {
        try {
            $this->importTransactions($rows);
        } catch (Throwable $e) {
            dump($e->getMessage(), $e->getTraceAsString());
        }
    }

    public function rules(): array
    {
        return [
            '*.source_id' => 'required|unique:transactions,reference',
            '*.reporting_category' => [
                'required', Rule::in([
                    'charge',
                    'dispute',
                    'dispute_reversal',
                    'fee',
                    'refund'
                ])
            ],
            '*.currency' => 'required|string',
            '*.gross' => 'required|numeric',
            '*.fee' => 'required|numeric',
            '*.net' => 'required|numeric',
            '*.description' => 'required|string',
            '*.customer_facing_amount' => 'required|numeric',
            '*.customer_facing_currency' => 'required|string',
            '*.customer_email' => 'nullable|string',
            '*.customer_name' => 'nullable|string',
            '*.shipping_address_line1' => 'nullable|string',
            '*.created' => 'date',
        ];
    }

    private function importTransactions(array $rows): void
    {
        Log::info('importing transactions');
        foreach ($rows as $key => $row) {
            ++$key;
            $imported = $this->createTransaction($row);
            $this->broadcast($key, $imported);
        }

        $this->endBroadcast();
    }

    public function onError(Throwable $e)
    {
        $this->errors[] = $e;
    }

    /**
     * @param $row
     * @return mixed
     */
    private function createTransaction($row)
    {
        $imported = UserDetail::create([
            'transaction_provider_id' => 1,
            'reference' => $row['source_id'],
            'reporting_category' => $row['reporting_category'],
            'currency_id' => $this->createService->getCurrencyId($row['currency']),
            'gross' => $row['gross'],
            'fee' => $row['fee'],
            'net' => $row['net'],
            'description' => $row['description'],
            'customer_facing_amount' => $row['customer_facing_amount'],
            'customer_facing_currency_id' => $this->createService->getCurrencyId($row['customer_facing_currency']),
            'customer_email' => $row['customer_email'],
            'customer_name' => $row['customer_name'],
            'shipping_address_line1' => $row['shipping_address_line1'],
            'shipping_address_line2' => $row['shipping_address_line2'],
            'shipping_address_city' => $row['shipping_address_city'],
            'shipping_address_state' => $row['shipping_address_state'],
            'shipping_address_postal_code' => $row['shipping_address_postal_code'],
            'shipping_address_country' => $row['shipping_address_country'],
            'payment_intent_id' => $row['payment_intent_id'],
//                'metadata' => $row['metadata'], // TODO: rework
            'transacted_at' => $row['created'],
        ]);

        return $imported;
    }

    /**
     * @param $key
     * @param $imported
     */
    private function broadcast($key, $imported): void
    {
        Storage::prepend(
            'public/imported_transactions.html',
            HtmlFacade::tag(
                'li',
                sprintf(
                    '%s. - %s: %s',
                    $key,
                    'Reference:',
                    $imported->reference,
                ),
                ['class' => 'broadcast']
            )
        );
    }

    private function endBroadcast(): void
    {
        Storage::prepend(
            'public/imported_transactions.html',
            HtmlFacade::tag('div', 'Process finished.', ['class' => 'is-success'])
        );
    }
}

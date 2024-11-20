<?php

/**
 * Default data request search parameters
 */

use App\Modules\Shared\Domain\Enums\OperationTypeEnum;
use App\Modules\Shared\Domain\Enums\PaginationParamsEnum;

return [
    'dev_mode' => env('DEV_MODE') === 'yes',
    'seed_transactions' => env('SEED_TRANSACTIONS') === 'yes',
    'seed_transactions_in_worker' => env('SEED_TRANSACTIONS_IN_WORKER') === 'yes',
    'sync_with_payment_processor' => env('SYNC_WITH_PAYMENT_PROCESSOR') === 'yes',
    'domain_request' => [
        'itemsPerPage' => PaginationParamsEnum::DEFAULT_ITEMS_PER_PAGE,
        'maxItemsPerPage' => 100,
        'currentPage' => 1,
        'sort_field' => 'id', //created_at
        'sort_type' => 'desc',
        'operation_type' => OperationTypeEnum::OR->value,
    ],
    'telegram' => [
        'bot_logger' => env('TELEGRAM_LOGGER_BOT_TOKEN', null),
        'bot_logger_channel' => env('TELEGRAM_LOGGER_CHAT_ID', null),
    ],
    'payment_processor' => [
        'user' => 'lclubapi@gmail.com',
        'password' => 'PF4xqO3XbJgYUYKrfZDcnPcdIFlMmcc/Ui3dyxTIDbufX/+xhakTkmqsXNHZF9RN',
        'customer_id' => '585e9c93-731c-4c0c-9f10-0d731d4ca8f7',
        'country' => 'MEX',
        'legal_type' => 'LEGAL_ENTITY',
    ],
    'websocket' => [
        'url' => env('WS_URL'),
    ],
    'log' => [
        'query' => env('LOG_QUERIES') === 'yes',
        'http' => env('LOG_HTTP') === 'yes',
    ],
    'report_diff_month' => 6,
    'image_art_extension' => 'svg',
    'zip_extension' => '7z',
    'commission_aggregator' => 2,
    'default_amex' => 3.60,
];

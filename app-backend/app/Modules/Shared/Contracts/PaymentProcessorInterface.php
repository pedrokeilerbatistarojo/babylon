<?php

namespace App\Modules\Shared\Contracts;

use App\Shared\Infrastructure\Services\PaymentProviderResponseException;

interface PaymentProcessorInterface
{
    /**
     * @throws PaymentProviderResponseException
     */
    public function login(string $user, string $password);

    /**
     * @throws PaymentProviderResponseException
     */
    public function getLastHourTransactions(int $page = 0, int $size = 10): array;

    /**
     * @throws PaymentProviderResponseException
     */
    public function getMonthTransactions(int $page = 0, int $size = 10): array;

    /**
     * @throws PaymentProviderResponseException
     */
    public function getTransactions(string $start, string $end, int $page = 0, int $size = 10): array;

    /**
     * @throws PaymentProviderResponseException
     */
    public function getTerminals(int $page = 0, int $size = 10000): array;

    /**
     * @throws PaymentProviderResponseException
     */
    public function createUser(array $userData): array;

    /**
     * @throws PaymentProviderResponseException
     */
    public function createFee(array $feeData): array;

    /**
     * @throws PaymentProviderResponseException
     */
    public function deleteFee(string $id): array;

    /**
     * @throws PaymentProviderResponseException
     */
    public function getFees(): array;

    /**
     * @throws PaymentProviderResponseException
     */
    public function setMerchantsFees(string $merchant_id, array $fees): array;

    /**
     * @throws PaymentProviderResponseException
     */
    public function getMerchants(int $page = 0, int $size = 10): array;

    /**
     * @throws PaymentProviderResponseException
     */
    public function createMerchant(array $merchantData): array;

    /**
     * @throws PaymentProviderResponseException
     */
    public function getWebhooks(): array;

    /**
     * @throws PaymentProviderResponseException
     */
    public function testWebhooks(): array;

    /**
     * @throws PaymentProviderResponseException
     */
    public function createWebhook(array $webhookData): array;

    /**
     * @throws PaymentProviderResponseException
     */
    public function deleteWebhook(string $id): array;
}

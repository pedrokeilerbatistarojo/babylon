<?php

namespace App\Shared\Infrastructure\Services;

use App\Shared\Contracts\PaymentProcessorInterface;
use App\Shared\Utils\JwtUtil;
use DateTime;
use DateTimeZone;
use Exception;
use Illuminate\Support\Facades\Cache;

class MentaPaymentProcessor implements PaymentProcessorInterface
{
    const CACHE_KEY = 'menta-login';

    const LOGIN_ENDPOINT = '/login';

    private string $baseUrl = 'https://api.menta.global/api/v1';

    private string $accessToken = '';

    /**
     * @throws PaymentProviderResponseException
     */
    public function login(string $user, string $password)
    {
        $token = Cache::get(self::CACHE_KEY);
        if ($token) {
            $this->accessToken = $token;

            return;
        }

        $data = [
            'user' => $user,
            'password' => $password,
        ];

        $response = $this->sendRequest('POST', self::LOGIN_ENDPOINT, $data);

        // Set the accessToken if present in the response
        if (isset($response['token']['access_token'])) {

            $token = $response['token']['access_token'];
            $this->accessToken = $token;

            // Decode payload
            $expTimestamp = JwtUtil::decodeJWT($token)['payload']['exp'];

            // Create a DateTime object and set the timestamp
            $expirationDate = new DateTime;
            $expirationDate->setTimestamp($expTimestamp);
            // Subtract 10 minutes from the expiration date
            $expirationDate->modify('-10 minutes');

            Cache::put(self::CACHE_KEY, $token, $expirationDate);
        } else {
            throw new Exception('Failed to obtain access_token');
        }

    }

    /**
     * @throws PaymentProviderResponseException
     */
    public function getLastHourTransactions(int $page = 0, int $size = 10): array
    {
        // Create a DateTime instance for the first day of the month
        $firstDay = new DateTime('now', new DateTimeZone('UTC'));

        // Clone the date to avoid modifying the first day
        $lastDay = clone $firstDay;

        // Modify to get the last day of the month
        $lastDay->modify('-1 hour');

        // Format to ISO 8601 with UTC (yyyy-MM-ddTHH:mm:ssZ)
        $start = $firstDay->format('Y-m-d\TH:i:s\Z');
        $end = $lastDay->format('Y-m-d\TH:i:s\Z');

        return $this->getTransactions($start, $end, $page, $size);
    }

    /**
     * @throws PaymentProviderResponseException
     */
    public function getMonthTransactions(int $page = 0, int $size = 10): array
    {
        // Create a DateTime instance for the first day of the month
        $firstDay = new DateTime('first day of this month', new DateTimeZone('UTC'));

        // Clone the date to avoid modifying the first day
        $lastDay = clone $firstDay;

        // Modify to get the last day of the month
        $lastDay->modify('last day of this month');

        // Format to ISO 8601 with UTC (yyyy-MM-ddTHH:mm:ssZ)
        $start = $firstDay->format('Y-m-d\TH:i:s\Z');
        $end = $lastDay->format('Y-m-d\TH:i:s\Z');

        return $this->getTransactions($start, $end, $page, $size);
    }

    /**
     * @throws PaymentProviderResponseException
     */
    public function getTransactions(string $start, string $end, int $page = 0, int $size = 10): array
    {
        return $this->sendRequest('GET', "/v2/transaction-reports?page=$page&size=$size&start=$start&end=$end");
    }

    /**
     * @throws PaymentProviderResponseException
     */
    public function getTerminals(int $page = 0, int $size = 10000): array
    {
        return $this->sendRequest('GET', "/terminals?page=$page&size=$size");
    }

    /**
     * @throws PaymentProviderResponseException
     */
    public function createUser(array $userData): array
    {
        return $this->sendRequest('POST', '/users', $userData);
    }

    /**
     * @throws PaymentProviderResponseException
     */
    public function getFees(): array
    {
        return $this->sendRequest('GET', '/fee-rules');
    }

    /**
     * @throws PaymentProviderResponseException
     */
    public function createFee(array $paymentData): array
    {
        return $this->sendRequest('POST', '/fee-rules', $paymentData);
    }

    /**
     * @throws PaymentProviderResponseException
     */
    public function deleteFee(string $id): array
    {
        return $this->sendRequest('DELETE', "/fee-rules/$id");
    }

    /**
     * @throws PaymentProviderResponseException
     */
    public function setMerchantsFees(string $merchant_id, array $fees): array
    {
        return $this->sendRequest('POST', "/merchants/$merchant_id/fee-rules", $fees);
    }

    /**
     * @throws PaymentProviderResponseException
     */
    public function getMerchants(int $page = 0, int $size = 10): array
    {
        return $this->sendRequest('GET', "/merchants?page=$page&size=$size");
    }

    /**
     * @throws PaymentProviderResponseException
     */
    public function createMerchant(array $merchantData): array
    {
        return $this->sendRequest('POST', '/merchants', $merchantData);
    }

    /**
     * @throws PaymentProviderResponseException
     */
    public function getWebhooks(): array
    {
        return $this->sendRequest('GET', '/webhooks');
    }

    /**
     * @throws PaymentProviderResponseException
     */
    public function createWebhook(array $webhookData): array
    {
        return $this->sendRequest('POST', '/webhooks', $webhookData);
    }

    /**
     * @throws PaymentProviderResponseException
     */
    public function deleteWebhook(string $id): array
    {
        return $this->sendRequest('DELETE', "/webhooks/$id");
    }

    /**
     * @throws PaymentProviderResponseException
     */
    public function testWebhooks(): array
    {
        return $this->sendRequest('POST', '/webhooks/mock/send-payment-notification');
    }

    /**
     * @throws PaymentProviderResponseException
     * @throws Exception
     */
    private function sendRequest(string $method, string $endpoint, ?array $data = null): array
    {
        $url = $this->baseUrl.$endpoint;

        if (str_contains($endpoint, '/v2')) {
            $url = str_replace('/v1', '', $url);
        }

        if ((! $this->accessToken) && ($endpoint !== self::LOGIN_ENDPOINT)) {
            $user = config('modules.payment_processor.user');
            $password = config('modules.payment_processor.password');
            $this->login($user, $password);
        }

        // Inicializar cURL
        $ch = curl_init($url);

        // Configurar opciones comunes de cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 180);
        $headers = [
            'Content-Type: application/json',
        ];

        // Agregar el token de autorización si está disponible
        if ($this->accessToken) {
            $headers[] = 'Authorization: Bearer '.$this->accessToken;
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $addData = false;

        // Definir método HTTP
        switch ($method) {
            case 'POST':
                $addData = (bool) ($data);
                curl_setopt($ch, CURLOPT_POST, true);
                break;
            case 'GET':
                curl_setopt($ch, CURLOPT_HTTPGET, true);
                break;
            case 'DELETE':
                $addData = (bool) ($data);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
            case 'PATCH':
                $addData = (bool) ($data);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
                break;
            default:
                throw new Exception("Unsupported request method: $method");
        }

        if ($addData) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        // Ejecutar la solicitud
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Verificar si ocurrió un error de cURL
        $error = curl_errno($ch);
        if ($error) {
            curl_close($ch);
            $message = 'cURL error: '.curl_error($ch);
            throw new Exception($message, $error);
        }

        curl_close($ch);

        if (! strlen($response)) {
            return [];
        }

        // Manejo de códigos HTTP
        if ($httpCode >= 200 && $httpCode < 300) {
            return json_decode($response, true);  // Retornar respuesta decodificada si es exitosa
        } else {

            $message = "HTTP Error: $httpCode, Response: $response";
            if ($response) {
                $response = json_decode($response, true);
                $errors = [
                    'url' => $url,
                    'method' => $method,
                    'code' => $httpCode,
                    'data' => $data,
                    'errors' => $response,
                ];
                throw new PaymentProviderResponseException($errors, $message, $httpCode);
            }

            throw new PaymentProviderResponseException([], $message, $httpCode);
        }
    }
}

<?php

namespace App\Services;

class DuitkuService
{
    protected $config;

    public function __construct()
    {
        require_once base_path('vendor/duitkupg/duitku-php/Duitku.php');

        $this->config = new \Duitku\Config(
            config('services.duitku.api_key'),
            config('services.duitku.merchant_code')
        );

        $this->config->setSandboxMode(config('services.duitku.sandbox', true));
        $this->config->setSanitizedMode(true);
        $this->config->setDuitkuLogs(false);
    }

    public function createInvoice(array $params)
    {
        return \Duitku\Api::createInvoice($params, $this->config);
    }

    public function checkStatus(string $merchantOrderId)
    {
        return \Duitku\Api::transactionStatus($merchantOrderId, $this->config);
    }

    public function callback()
    {
        $callback = \Duitku\Api::callback($this->config);
        return json_decode($callback, true);
    }

    public function paymentMethode($amount)
    {
        $callback = \Duitku\Api::getPaymentMethod($amount, $this->config);
        return json_decode($callback, true);
    }
}

<?php

/*
 * Qiwi driver for Omnipay PHP payment library
 *
 * @link      https://github.com/hiqdev/omnipay-qiwi
 * @package   omnipay-qiwi
 * @license   MIT
 * @copyright Copyright (c) 2015, HiQDev (http://hiqdev.com/)
 */

namespace Omnipay\Qiwi\Message;

class PurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate(
            'providerId',
            'amount', 'currency', 'description',
            'returnUrl', 'cancelUrl', 'notifyUrl'
        );

        return [
            'from'       => $this->getProviderId(),
            'summ'       => $this->getAmount(),
            'currency'   => strtoupper($this->getCurrency()),
            'successUrl' => $this->getSuccessUrl(),
            'failUrl'    => $this->getFailureUrl(),
            'txn_id'     => $this->getTransactionId(),
            'comm'       => $this->getDescription(),
            'alarm'      => 0,
        ];
    }

    public function sendData($data)
    {
        return $this->response = new PurchaseResponse($this, $data);
    }
}

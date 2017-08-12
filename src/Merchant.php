<?php
/**
 * Qiwi driver for Omnipay PHP payment library
 *
 * @link      https://github.com/hiqdev/omnipay-qiwi
 * @package   omnipay-qiwi
 * @license   MIT
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\php\merchant\qiwi;

class Merchant extends \hiqdev\php\merchant\Merchant
{
    protected static $_defaults = [
        'system'      => 'qiwi',
        'label'       => 'Qiwi',
        'method'      => 'GET',
        'checkUrl'    => 'https://ishop.qiwi.ru/xml',
        'actionUrl'   => 'https://w.qiwi.com/order/external/create.action',
        'confirmText' => '<?xml version="1.0"?> <result><result_code>0</result_code></result>',
    ];

    public function getInputs()
    {
        return [
            'from'       => $this->purse,
            'summ'       => $this->total,
            'currency'   => strtoupper($this->currency),
            'successUrl' => $this->successUrl,
            'failUrl'    => $this->failureUrl,
            'txn_id'     => $this->username . '-' . time(),
            'comm'       => $this->description,
            'alarm'      => 0,
        ];
    }

    public function validateConfirmation($data)
    {
        $bill = $this->_fetchBill($data);
        if (is_string($bill)) {
            return $bill;
        }
        $time = explode('-', $bill['id'])[1];
        $this->mset([
        //  'from'  => ??? TODO need some from
            'txn'   => $data['order'],
            'sum'   => floatval($bill['sum']),
            'time'  => date('c', $time),
        ]);
        return true;
    }

    protected function _fetchBill($data)
    {
        $order = $data['order'] ?: $data['bill_id'];
        if (!$order) {
            return 'No order';
        }
        for ($i = 0; $i < 10; ++$i) {
            sleep(1);
            $qiwiRequest = $this->fetchQiwiResponse($order, $this->purse, $this->_secret);
            if (!$qiwiRequest) {
                return 'Server failure';
            }
            $bill = $qiwiRequest->{'bills-list'}->bill;
            if ($bill['status'] === 60) {
                return $bill;
            }
            if ($bill['status'] === 52) {
                continue;
            }
            return 'Wrong status';
        }
        return 'Too many tries';
    }

    public function fetchQiwiResponse($txnId, $login, $password)
    {
        $xml = '<?xml version="1.0" encoding="utf-8"?>
        <request>
            <protocol-version>4.00</protocol-version>
            <request-type>33</request-type>
            <terminal-id>' . $login . '</terminal-id>
            <extra name="password">' . $password . '</extra>
            <bills-list>
            <bill txn-id="' . $txnId . '"/>
            </bills-list>
        </request>';
        $res = static::curl($this->checkUrl, $xml);
        $res = simplexml_load_string($res);
        return $res ? $res : false;
    }
}

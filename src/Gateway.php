<?php
/**
 * Qiwi driver for Omnipay PHP payment library
 *
 * @link      https://github.com/hiqdev/omnipay-qiwi
 * @package   omnipay-qiwi
 * @license   MIT
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace Omnipay\Qiwi;

use Omnipay\Common\AbstractGateway;

/**
 * Gateway for Visa QIWI Wallet.
 * https://static.qiwi.com/ru/doc/ishop/protocols/Visa_QIWI_Wallet_Pull_Payments_API.pdf.
 */
class Gateway extends AbstractGateway
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Qiwi';
    }

    public function getAssetDir()
    {
        return dirname(__DIR__) . '/assets';
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultParameters()
    {
        return [
            'providerId'    => '',
            'secretKey'     => '',
            'testMode'      => false,
        ];
    }

    /**
     * Get the unified purse.
     *
     * @return string provider ID
     */
    public function getPurse()
    {
        return $this->getProviderId();
    }

    /**
     * Set the unified purse.
     *
     * @param string $purse provider ID
     *
     * @return self
     */
    public function setPurse($value)
    {
        return $this->setProviderId($value);
    }

    /**
     * Get the provider ID.
     *
     * @return string provider ID
     */
    public function getProviderId()
    {
        return $this->getParameter('providerId');
    }

    /**
     * Set the provider ID.
     *
     * @param string $value provider ID
     *
     * @return self
     */
    public function setProviderId($value)
    {
        return $this->setParameter('providerId', $value);
    }

    /**
     * Get the secret key.
     *
     * @return string secret key
     */
    public function getSecretKey()
    {
        return $this->getParameter('secretKey');
    }

    /**
     * Set the secret key.
     *
     * @param string $value secret key
     *
     * @return self
     */
    public function setSecretKey($value)
    {
        return $this->setParameter('secretKey', $value);
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\Qiwi\Message\PurchaseRequest
     */
    public function purchase(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\Qiwi\Message\PurchaseRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\Qiwi\Message\CompletePurchaseRequest
     */
    public function completePurchase(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\Qiwi\Message\CompletePurchaseRequest', $parameters);
    }
}

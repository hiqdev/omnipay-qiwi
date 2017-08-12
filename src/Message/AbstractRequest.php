<?php
/**
 * Qiwi driver for Omnipay PHP payment library
 *
 * @link      https://github.com/hiqdev/omnipay-qiwi
 * @package   omnipay-qiwi
 * @license   MIT
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace Omnipay\Qiwi\Message;

/**
 * Qiwi Abstract Request.
 */
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $zeroAmountAllowed = false;

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
     * @param string $purse provider ID
     *
     * @return self
     */
    public function setProviderId($purse)
    {
        return $this->setParameter('providerId', $purse);
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
     * @param string $key secret key
     *
     * @return self
     */
    public function setSecretKey($key)
    {
        return $this->setParameter('secretKey', $key);
    }
}

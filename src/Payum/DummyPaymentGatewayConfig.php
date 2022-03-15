<?php

namespace App\Payum;

final class DummyPaymentGatewayConfig
{
    /** @var bool */
    private bool $sandbox;

    /** @var bool */
    private bool $alwaysRejectPayment;

    public function __construct(
        bool $sandbox,
        bool $alwaysRejectPayment = false
    ) {
        $this->sandbox = $sandbox;   
        $this->alwaysRejectPayment = $alwaysRejectPayment;
    }

    /**
     * Get the value of sandbox
     *
     * @return bool
     */
    public function isSandbox()
    {
        return $this->sandbox;
    }

    /**
     * Set the value of sandbox
     *
     * @param bool $sandbox
     *
     * @return self
     */
    public function setSandbox(bool $sandbox)
    {
        $this->sandbox = $sandbox;

        return $this;
    }

    /**
     * Get the value of alwaysRejectPayment
     *
     * @return bool
     */
    public function isAlwaysRejectPayment()
    {
        return $this->alwaysRejectPayment;
    }

    /**
     * Set the value of alwaysRejectPayment
     *
     * @param bool $alwaysRejectPayment
     *
     * @return self
     */
    public function setAlwaysRejectPayment(bool $alwaysRejectPayment)
    {
        $this->alwaysRejectPayment = $alwaysRejectPayment;

        return $this;
    }
}
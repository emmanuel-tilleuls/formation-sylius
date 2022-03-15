<?php

namespace App\Payum\Action;

use App\Payum\DummyPaymentGatewayConfig;
use Payum\Core\Action\ActionInterface;
use Payum\Core\ApiAwareInterface;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Exception\UnsupportedApiException;
use Payum\Core\Request\Capture;
use Sylius\Component\Core\Model\PaymentInterface as SyliusPaymentInterface;

final class CaptureAction implements ActionInterface, ApiAwareInterface
{
    private DummyPaymentGatewayConfig $config;

    public function execute($request)
    {
        RequestNotSupportedException::assertSupports($this, $request);

        /** @var SyliusPaymentInterface $payment */
        $payment = $request->getModel();

        // TODO something clever : use external payment service via its API
        $amount = $payment->getAmount();
        $currency = $payment->getCurrencyCode();

        // TODO ne pas utiliser les code http en dur
        if ($this->config->isAlwaysRejectPayment()) {
            $payment->setDetails(['status' => 400]); // 400 sera testé dan StatusAction
        } else {
            $payment->setDetails(['status' => 200]); // 200 sera testé dan StatusAction
        }
    }

    public function supports($request)
    {
        return
            $request instanceof Capture &&
            $request->getModel() instanceof SyliusPaymentInterface
        ;        
    }

    // permet de récupérer la *configuration* (la DTO)
    public function setApi($api)
    {
        if (!$api instanceof DummyPaymentGatewayConfig) {
            throw new UnsupportedApiException('Instance of DummyPaymentGatewayConfig expceted');

        }

        $this->config = $api;
    }
}
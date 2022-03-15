<?php

namespace App\Payum;

use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\GatewayFactory;

class DummyPaymentGatewayFactory extends GatewayFactory
{
    /* Constructeur pour la version d'Arnaud (voir service.yaml)
    public function __construct(private $statusAction, private $captureAction)
    {
        parent::__construct();
    }
    */

    // Équivalent d'un config resolver
    protected function populateConfig(ArrayObject $config): void
    {
        $config->defaults([
            'payum.factory_name' => 'dummy_payment',
            'payum.factory_title' => 'Dummy Payment',
            // configuration des actions : version d'Arnaud (voir service.yaml)
            //'payum.action.status' => $this->statusAction,
            //'payum.action.capture' => $this->captureAction,
        ]);

        // va être alimenté avec le contenu de ce qu'il y aura dans
        $config['payum.api'] = function (ArrayObject $config) {
            return new DummyPaymentGatewayConfig(
                $config['sandbox'],
                $config['alwaysRejectPayment'],
            );
        };
    }
}
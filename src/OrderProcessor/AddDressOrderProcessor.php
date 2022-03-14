<?php

namespace App\OrderProcessor;

use Sylius\Behat\Service\Setter\ChannelContextSetterInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Factory\CartItemFactory;
use Sylius\Component\Order\Model\OrderInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Sylius\Component\Order\Model\OrderItem;
use Sylius\Component\Order\Model\OrderItemUnit;
use Sylius\Component\Order\Processor\OrderProcessorInterface;
use Sylius\Component\Product\Repository\ProductRepositoryInterface;
use Sylius\Component\Taxonomy\Repository\TaxonRepositoryInterface;
use Sylius\Component\Taxonomy\Model\TaxonInterface;

class AddDressOrderProcessor implements OrderProcessorInterface
{
    public function __construct(
        private ChannelContextInterface $channelContext,
        private LocaleContextInterface $localeContext,
        private CartItemFactory $cartItemFactory,
        private TaxonRepositoryInterface $taxonRepository,
        private ProductRepositoryInterface $productRepository,
    ) {
    }

    private function orderHasTShirt(OrderInterface $order)
    {
        /** @var \App\Entity\Order\Order\OrderItem $item */
        foreach ($order->getItems() as $item) {
            /** @var ProductInterface $product */
            $product = $item->getProduct();
            foreach ($product->getTaxons() as $taxon) {
                if ($taxon->getCode() == 't_shirts') {
                    return true;
                }
            }
        }

        return false;
    }

    public function process(OrderInterface $order): void
    {
        // Remove previously added dress
        // TODO

        if ($this->orderHasTShirt($order)) {
            // Looking for dress to add 
            /** @var TaxonInterface $dressesTaxon */
            $dressesTaxon = $this->taxonRepository->findOneBy(['code' => 'dresses']);

            $products = $this->productRepository
                ->createShopListQueryBuilder(
                    $this->channelContext->getChannel(),
                    $dressesTaxon,
                    $this->localeContext->getLocaleCode()


                )

            $cartItem = $this->cartItemFactory->createForProduct();

            $order->addItem($cartItem);
        }
    }
}
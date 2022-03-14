<?php

namespace App\OrderProcessor;

use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Factory\CartItemFactory;
use Sylius\Component\Core\Factory\CartItemFactoryInterface;
use Sylius\Component\Order\Model\OrderInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Sylius\Component\Order\Factory\OrderItemUnitFactoryInterface;
use Sylius\Component\Order\Modifier\OrderItemQuantityModifierInterface;
use Sylius\Component\Order\Modifier\OrderModifierInterface;
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
        private OrderItemUnitFactoryInterface $orderItemUnitFactory,
        private TaxonRepositoryInterface $taxonRepository,
        private ProductRepositoryInterface $productRepository,
        private OrderModifierInterface $orderModifier,
        private OrderItemQuantityModifierInterface $orderItemQuantityModifier,
    ) {
    }

    private function orderHasTShirt(OrderInterface $order)
    {
        /** @var \App\Entity\Order\Order\OrderItem $item */
        foreach ($order->getItems() as $item) {
            /** @var ProductInterface $product */
            $product = $item->getProduct();
            foreach ($product->getProductTaxons() as $taxon) {
                if ($taxon->getTaxon()->getCode() == 't_shirts') {
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

        if (!$this->orderHasTShirt($order)) {
            return;
        }

        // Looking for dress to add 
        /** @var TaxonInterface $dressesTaxon */
        $dressesTaxon = $this->taxonRepository->findOneBy(['code' => 'dresses']);

        /** @var \Sylius\Bundle\CoreBundle\Doctrine\ORM\ProductRepository $productRepository */
        $productRepository = $this->productRepository;
        $products = $productRepository
            ->createShopListQueryBuilder(
                $this->channelContext->getChannel(),
                $dressesTaxon,
                $this->localeContext->getLocaleCode()
            )
            ->getQuery()
            ->getResult()
        ;

        $cartItem = $this->cartItemFactory->createForProduct($products[0]);

        // Attention : il faudrait choisir le bonne variant

        $cartItem->setUnitPrice(0);
        $cartItem->addUnit($this->orderItemUnitFactory->createForItem($cartItem));

        //$this->orderItemQuantityModifier->modify()

        $order->addItem($cartItem);
    }
}
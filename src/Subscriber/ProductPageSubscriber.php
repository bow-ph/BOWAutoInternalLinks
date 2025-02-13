<?php declare(strict_types=1);

namespace BOWAutoInternalLinks\Subscriber;

use BOWAutoInternalLinks\Service\TagLinkService;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Shopware\Storefront\Page\Product\ProductPageLoadedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ProductPageSubscriber implements EventSubscriberInterface
{
    private TagLinkService $tagLinkService;
    private SystemConfigService $systemConfigService;

    public function __construct(
        TagLinkService $tagLinkService,
        SystemConfigService $systemConfigService
    ) {
        $this->tagLinkService = $tagLinkService;
        $this->systemConfigService = $systemConfigService;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ProductPageLoadedEvent::class => 'onProductPageLoaded'
        ];
    }

    public function onProductPageLoaded(ProductPageLoadedEvent $event): void
    {
        if (!$this->systemConfigService->get('BOWAutoInternalLinks.config.enableProductLinks')) {
            return;
        }

        $maxLinks = (int) $this->systemConfigService->get('BOWAutoInternalLinks.config.maxLinksPerPage', 3);
        $product = $event->getPage()->getProduct();
        
        $relatedProducts = $this->tagLinkService->findRelatedProductsByTags(
            $product->getId(),
            $event->getContext(),
            $maxLinks
        );

        $event->getPage()->addExtension('bowAutoLinks', $relatedProducts);
    }
}

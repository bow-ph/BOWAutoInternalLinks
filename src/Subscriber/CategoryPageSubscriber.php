<?php declare(strict_types=1);

namespace BOWAutoInternalLinks\Subscriber;

use BOWAutoInternalLinks\Service\LinkGeneratorService;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Shopware\Storefront\Page\Category\CategoryPageLoadedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CategoryPageSubscriber implements EventSubscriberInterface
{
    private LinkGeneratorService $linkGenerator;
    private SystemConfigService $systemConfigService;

    public function __construct(
        LinkGeneratorService $linkGenerator,
        SystemConfigService $systemConfigService
    ) {
        $this->linkGenerator = $linkGenerator;
        $this->systemConfigService = $systemConfigService;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            CategoryPageLoadedEvent::class => 'onCategoryPageLoaded'
        ];
    }

    public function onCategoryPageLoaded(CategoryPageLoadedEvent $event): void
    {
        if (!$this->systemConfigService->get('BOWAutoInternalLinks.config.enableCategoryLinks')) {
            return;
        }

        $maxLinks = (int) $this->systemConfigService->get('BOWAutoInternalLinks.config.maxLinksPerPage', 3);
        $category = $event->getPage()->getCategory();
        
        $relatedProducts = $this->linkGenerator->generateCategoryLinks(
            $category->getId(),
            $event->getContext(),
            $maxLinks
        );

        $event->getPage()->addExtension('bowAutoLinks', $relatedProducts);
    }
}

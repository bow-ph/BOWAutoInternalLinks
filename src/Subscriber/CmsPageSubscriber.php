<?php declare(strict_types=1);

namespace BOWAutoInternalLinks\Subscriber;

use BOWAutoInternalLinks\Service\LinkGeneratorService;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Shopware\Storefront\Page\Page;
use Shopware\Storefront\Page\GenericPage;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CmsPageSubscriber implements EventSubscriberInterface
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
            'Shopware\Core\Content\Cms\Events\CmsPageLoadedEvent' => 'onCmsPageLoaded'
        ];
    }

    public function onCmsPageLoaded(\Shopware\Core\Content\Cms\Events\CmsPageLoadedEvent $event): void
    {
        if (!$this->systemConfigService->get('BOWAutoInternalLinks.config.enableCmsLinks')) {
            return;
        }

        $maxLinks = (int) $this->systemConfigService->get('BOWAutoInternalLinks.config.maxLinksPerPage', 3);
        
        foreach ($event->getResult() as $page) {
            if ($page->getTags() && $page->getTags()->count() > 0) {
                $relatedProducts = $this->linkGenerator->generateCmsLinks(
                    $page->getId(),
                    $event->getContext(),
                    $maxLinks
                );
                
                $page->addExtension('bowAutoLinks', $relatedProducts);
            }
        }
    }
}

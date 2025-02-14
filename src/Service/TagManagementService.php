<?php declare(strict_types=1);

namespace BOWAutoInternalLinks\Service;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;

class TagManagementService
{
    private EntityRepository $tagRepository;
    private EntityRepository $autoLinkRepository;

    public function __construct(
        EntityRepository $tagRepository,
        EntityRepository $autoLinkRepository
    ) {
        $this->tagRepository = $tagRepository;
        $this->autoLinkRepository = $autoLinkRepository;
    }

    public function getTagStatistics(Context $context): array
    {
        $criteria = new Criteria();
        $criteria->addAssociation('products');
        $criteria->addAssociation('categories');
        // ✅ Ensure 'customFields' is explicitly included
        $criteria->addAssociation('customFields');
        
        $tags = $this->tagRepository->search($criteria, $context);
        $statistics = [];

        foreach ($tags as $tag) {
            $statistics[$tag->getId()] = [
                'id' => $tag->getId(),
                'name' => $tag->getName(),
                'productCount' => $tag->getProducts()->count(),
                'categoryCount' => $tag->getCategories()->count(),
                'linkCount' => $this->getTagLinkCount($tag->getId(), $context)
            ];
        }

        return $statistics;
    }

    public function getTagLinkCount(string $tagId, Context $context): int
    {
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('matchedTags', $tagId));
        
        return $this->autoLinkRepository->search($criteria, $context)->getTotal();
    }

    public function updateTagPriority(string $tagId, float $priority, Context $context): void
    {
        $this->tagRepository->update([
            [
                'id' => $tagId,
                'customFields' => ['bowAutoLinks' => ['priority' => $priority]]
            ]
        ], $context);
    }
}

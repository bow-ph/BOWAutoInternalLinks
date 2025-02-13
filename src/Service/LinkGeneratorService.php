<?php declare(strict_types=1);

namespace BOWAutoInternalLinks\Service;

use BOWAutoInternalLinks\Entity\AutoLink;
use BOWAutoInternalLinks\Entity\AutoLinkCollection;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\NotFilter;
use Shopware\Core\Framework\Uuid\Uuid;
use Symfony\Component\Cache\Adapter\TagAwareAdapterInterface;

class LinkGeneratorService
{
    private EntityRepository $autoLinkRepository;
    private EntityRepository $productRepository;
    private EntityRepository $categoryRepository;
    private TagAwareAdapterInterface $cache;

    public function __construct(
        EntityRepository $autoLinkRepository,
        EntityRepository $productRepository,
        EntityRepository $categoryRepository,
        TagAwareAdapterInterface $cache
    ) {
        $this->autoLinkRepository = $autoLinkRepository;
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->cache = $cache;
    }

    public function generateProductLinks(string $productId, Context $context, int $maxLinks = 3): array
    {
        $cacheKey = sprintf('auto_links_product_%s', $productId);
        $cacheItem = $this->cache->getItem($cacheKey);

        if ($cacheItem->isHit()) {
            return $cacheItem->get();
        }

        $criteria = new Criteria([$productId]);
        $criteria->addAssociation('tags');
        
        $product = $this->productRepository->search($criteria, $context)->first();
        if (!$product || empty($product->getTags())) {
            return [];
        }

        $tagIds = array_map(fn($tag) => $tag->getId(), $product->getTags()->getElements());
        
        $relatedCriteria = new Criteria();
        $relatedCriteria->addAssociation('tags');
        $relatedCriteria->addFilter(new NotFilter(NotFilter::CONNECTION_AND, [
            new EqualsFilter('id', $productId)
        ]));
        $relatedCriteria->setLimit($maxLinks);

        $relatedProducts = $this->productRepository->search($relatedCriteria, $context);
        
        $links = [];
        foreach ($relatedProducts as $relatedProduct) {
            $relatedTagIds = array_map(fn($tag) => $tag->getId(), $relatedProduct->getTags()->getElements());
            $matchedTags = array_intersect($tagIds, $relatedTagIds);
            
            if (!empty($matchedTags)) {
                $autoLink = new AutoLink();
                $autoLink->setId(Uuid::randomHex());
                $autoLink->setSourceId($productId);
                $autoLink->setSourceType('product');
                $autoLink->setTargetId($relatedProduct->getId());
                $autoLink->setTargetType('product');
                $autoLink->setMatchedTags($matchedTags);
                $autoLink->setRelevanceScore(count($matchedTags) / count($tagIds));
                
                $links[] = $autoLink;
            }
        }

        usort($links, fn($a, $b) => $b->getRelevanceScore() <=> $a->getRelevanceScore());
        $links = array_slice($links, 0, $maxLinks);

        $cacheItem->set($links);
        $cacheItem->expiresAfter(86400); // 24 hours
        $this->cache->save($cacheItem);

        return $links;
    }

    public function generateCategoryLinks(string $categoryId, Context $context, int $maxLinks = 3): array
    {
        $cacheKey = sprintf('auto_links_category_%s', $categoryId);
        $cacheItem = $this->cache->getItem($cacheKey);

        if ($cacheItem->isHit()) {
            return $cacheItem->get();
        }

        $criteria = new Criteria([$categoryId]);
        $criteria->addAssociation('tags');
        
        $category = $this->categoryRepository->search($criteria, $context)->first();
        if (!$category || empty($category->getTags())) {
            return [];
        }

        $tagIds = array_map(fn($tag) => $tag->getId(), $category->getTags()->getElements());
        
        $productCriteria = new Criteria();
        $productCriteria->addAssociation('tags');
        $productCriteria->setLimit($maxLinks);

        $products = $this->productRepository->search($productCriteria, $context);
        
        $links = [];
        foreach ($products as $product) {
            $productTagIds = array_map(fn($tag) => $tag->getId(), $product->getTags()->getElements());
            $matchedTags = array_intersect($tagIds, $productTagIds);
            
            if (!empty($matchedTags)) {
                $autoLink = new AutoLink();
                $autoLink->setId(Uuid::randomHex());
                $autoLink->setSourceId($categoryId);
                $autoLink->setSourceType('category');
                $autoLink->setTargetId($product->getId());
                $autoLink->setTargetType('product');
                $autoLink->setMatchedTags($matchedTags);
                $autoLink->setRelevanceScore(count($matchedTags) / count($tagIds));
                
                $links[] = $autoLink;
            }
        }

        usort($links, fn($a, $b) => $b->getRelevanceScore() <=> $a->getRelevanceScore());
        $links = array_slice($links, 0, $maxLinks);

        $cacheItem->set($links);
        $cacheItem->expiresAfter(86400); // 24 hours
        $this->cache->save($cacheItem);

        return $links;
    }
}

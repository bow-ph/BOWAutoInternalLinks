<?php declare(strict_types=1);

namespace BOWAutoInternalLinks\Core\Content\Tag;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * @extends EntityCollection<TagEntity>
 */
class TagCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return TagEntity::class;
    }
}

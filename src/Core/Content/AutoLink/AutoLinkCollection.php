<?php declare(strict_types=1);

namespace BOWAutoInternalLinks\Core\Content\AutoLink;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * @method void                add(AutoLinkEntity $entity)
 * @method void                set(string $key, AutoLinkEntity $entity)
 * @method AutoLinkEntity[]    getIterator()
 * @method AutoLinkEntity[]    getElements()
 * @method AutoLinkEntity|null get(string $key)
 * @method AutoLinkEntity|null first()
 * @method AutoLinkEntity|null last()
 */
class AutoLinkCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return AutoLinkEntity::class;
    }
}

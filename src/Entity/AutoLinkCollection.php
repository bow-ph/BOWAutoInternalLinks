<?php declare(strict_types=1);

namespace BOWAutoInternalLinks\Entity;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * @method void               add(AutoLink $entity)
 * @method void               set(string $key, AutoLink $entity)
 * @method AutoLink[]         getIterator()
 * @method AutoLink[]         getElements()
 * @method AutoLink|null      get(string $key)
 * @method AutoLink|null      first()
 * @method AutoLink|null      last()
 */
class AutoLinkCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return AutoLink::class;
    }
}

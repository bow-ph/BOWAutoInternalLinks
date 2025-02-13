<?php declare(strict_types=1);

namespace BOWAutoInternalLinks\Core\Content\Tag;

use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;

class TagEntity extends Entity
{
    use EntityIdTrait;

    /**
     * @var string
     */
    protected $name;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}

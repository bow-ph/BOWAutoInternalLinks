<?php declare(strict_types=1);

namespace BOWAutoInternalLinks\Core\Content\AutoLink;

use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;

class AutoLinkEntity extends Entity
{
    use EntityIdTrait;

    protected string $sourceId;
    protected string $sourceType;
    protected string $targetId;
    protected string $targetType;
    protected array $matchedTags;
    protected ?array $customFields;

    public function getSourceId(): string
    {
        return $this->sourceId;
    }

    public function setSourceId(string $sourceId): void
    {
        $this->sourceId = $sourceId;
    }

    public function getSourceType(): string
    {
        return $this->sourceType;
    }

    public function setSourceType(string $sourceType): void
    {
        $this->sourceType = $sourceType;
    }

    public function getTargetId(): string
    {
        return $this->targetId;
    }

    public function setTargetId(string $targetId): void
    {
        $this->targetId = $targetId;
    }

    public function getTargetType(): string
    {
        return $this->targetType;
    }

    public function setTargetType(string $targetType): void
    {
        $this->targetType = $targetType;
    }

    public function getMatchedTags(): array
    {
        return $this->matchedTags;
    }

    public function setMatchedTags(array $matchedTags): void
    {
        $this->matchedTags = $matchedTags;
    }

    public function getCustomFields(): ?array
    {
        return $this->customFields;
    }

    public function setCustomFields(?array $customFields): void
    {
        $this->customFields = $customFields;
    }
}

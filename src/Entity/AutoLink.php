<?php declare(strict_types=1);

namespace BOWAutoInternalLinks\Entity;

use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;

class AutoLink extends Entity
{
    use EntityIdTrait;

    protected string $sourceId;
    protected string $sourceType;
    protected string $targetId;
    protected string $targetType;
    protected array $matchedTags;
    protected float $relevanceScore;
    protected \DateTimeInterface $createdAt;

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

    public function getRelevanceScore(): float
    {
        return $this->relevanceScore;
    }

    public function setRelevanceScore(float $relevanceScore): void
    {
        $this->relevanceScore = $relevanceScore;
    }
}

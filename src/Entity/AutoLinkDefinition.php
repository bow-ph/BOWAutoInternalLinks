<?php declare(strict_types=1);

namespace BOWAutoInternalLinks\Entity;

use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\CreatedAtField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\FloatField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\JsonField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;

class AutoLinkDefinition extends EntityDefinition
{
    public const ENTITY_NAME = 'bow_auto_link';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getEntityClass(): string
    {
        return AutoLink::class;
    }

    public function getCollectionClass(): string
    {
        return AutoLinkCollection::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new IdField('id', 'id'))->addFlags(new Required(), new PrimaryKey()),
            (new StringField('source_id', 'sourceId'))->addFlags(new Required()),
            (new StringField('source_type', 'sourceType'))->addFlags(new Required()),
            (new StringField('target_id', 'targetId'))->addFlags(new Required()),
            (new StringField('target_type', 'targetType'))->addFlags(new Required()),
            (new JsonField('matched_tags', 'matchedTags'))->addFlags(new Required()),
            (new FloatField('relevance_score', 'relevanceScore'))->addFlags(new Required()),
            new CreatedAtField(),
        ]);
    }
}

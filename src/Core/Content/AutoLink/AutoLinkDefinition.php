<?php declare(strict_types=1);

namespace BOWAutoInternalLinks\Core\Content\AutoLink;

use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\JsonField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;

class AutoLinkDefinition extends EntityDefinition
{
    public const ENTITY_NAME = 'bow_auto_link';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getCollectionClass(): string
    {
        return AutoLinkCollection::class;
    }

    public function getEntityClass(): string
    {
        return AutoLinkEntity::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new IdField('id', 'id'))->addFlags(new Required(), new PrimaryKey()),
            new StringField('source_id', 'sourceId'),
            new StringField('source_type', 'sourceType'),
            new StringField('target_id', 'targetId'),
            new StringField('target_type', 'targetType'),
            new JsonField('matched_tags', 'matchedTags'),
            new JsonField('custom_fields', 'customFields'),
        ]);
    }
}

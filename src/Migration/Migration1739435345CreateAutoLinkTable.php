<?php declare(strict_types=1);

namespace BOWAutoInternalLinks\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1739435345CreateAutoLinkTable extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1739435345;
    }

    public function update(Connection $connection): void
    {
        $connection->executeStatement('
            CREATE TABLE IF NOT EXISTS `bow_auto_link` (
                `id` BINARY(16) NOT NULL,
                `source_id` BINARY(16) NOT NULL,
                `source_type` VARCHAR(255) NOT NULL,
                `target_id` BINARY(16) NOT NULL,
                `target_type` VARCHAR(255) NOT NULL,
                `matched_tags` JSON NOT NULL,
                `relevance_score` DOUBLE NOT NULL,
                `created_at` DATETIME(3) NOT NULL,
                `updated_at` DATETIME(3) NULL,
                PRIMARY KEY (`id`),
                KEY `idx.source` (`source_id`, `source_type`),
                KEY `idx.target` (`target_id`, `target_type`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ');
    }

    public function updateDestructive(Connection $connection): void
    {
    }
}

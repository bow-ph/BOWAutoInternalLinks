<?php declare(strict_types=1);

namespace BOWAutoInternalLinks\Service;

use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Formatter\LineFormatter;
use Shopware\Core\Framework\Context;

class LinkGenerationLogger
{
    private Logger $logger;
    private string $logDir;

    public function __construct(string $projectDir)
    {
        $this->logDir = $projectDir . '/var/log/bow_auto_links';
        $this->initLogger();
    }

    private function initLogger(): void
    {
        $this->logger = new Logger('bow_auto_links');
        
        $handler = new RotatingFileHandler(
            $this->logDir . '/auto_links.log',
            14, // Keep logs for 14 days
            Logger::INFO
        );
        
        $formatter = new LineFormatter(
            "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n",
            "Y-m-d H:i:s"
        );
        
        $handler->setFormatter($formatter);
        $this->logger->pushHandler($handler);
    }

    public function logLinkGeneration(
        string $sourceId,
        string $sourceType,
        string $targetId,
        string $targetType,
        array $matchedTags,
        float $relevanceScore,
        Context $context
    ): void {
        $this->logger->info('Link generated', [
            'sourceId' => $sourceId,
            'sourceType' => $sourceType,
            'targetId' => $targetId,
            'targetType' => $targetType,
            'matchedTags' => $matchedTags,
            'relevanceScore' => $relevanceScore,
            'contextToken' => $context->getToken()
        ]);
    }

    public function getLogStats(): array
    {
        $stats = [
            'totalLinks' => 0,
            'averageRelevance' => 0,
            'topTags' => [],
            'generationsByType' => [
                'product' => 0,
                'category' => 0,
                'cms' => 0
            ]
        ];

        if (!file_exists($this->logDir . '/auto_links.log')) {
            return $stats;
        }

        $logContent = file_get_contents($this->logDir . '/auto_links.log');
        $lines = explode("\n", $logContent);
        $relevanceSum = 0;
        $tagCounts = [];

        foreach ($lines as $line) {
            if (empty($line)) {
                continue;
            }

            $data = json_decode($line, true);
            if (!$data) {
                continue;
            }

            $stats['totalLinks']++;
            $relevanceSum += $data['relevanceScore'] ?? 0;
            $stats['generationsByType'][$data['sourceType'] ?? 'other']++;

            foreach ($data['matchedTags'] ?? [] as $tag) {
                $tagCounts[$tag] = ($tagCounts[$tag] ?? 0) + 1;
            }
        }

        if ($stats['totalLinks'] > 0) {
            $stats['averageRelevance'] = $relevanceSum / $stats['totalLinks'];
        }

        arsort($tagCounts);
        $stats['topTags'] = array_slice($tagCounts, 0, 10, true);

        return $stats;
    }
}

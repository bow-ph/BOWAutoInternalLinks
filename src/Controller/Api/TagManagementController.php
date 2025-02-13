<?php declare(strict_types=1);

namespace BOWAutoInternalLinks\Controller\Api;

use BOWAutoInternalLinks\Service\TagManagementService;
use BOWAutoInternalLinks\Service\LinkGenerationLogger;
use Shopware\Core\Framework\Context;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(defaults={"_routeScope"={"api"}})
 */
class TagManagementController extends AbstractController
{
    private TagManagementService $tagManagementService;
    private LinkGenerationLogger $logger;

    public function __construct(
        TagManagementService $tagManagementService,
        LinkGenerationLogger $logger
    ) {
        $this->tagManagementService = $tagManagementService;
        $this->logger = $logger;
    }

    /**
     * @Route("/api/_action/bow-auto-links/tag-stats", name="api.action.bow.auto.links.tag.stats", methods={"GET"})
     */
    public function getTagStats(Context $context): JsonResponse
    {
        return new JsonResponse($this->tagManagementService->getTagStatistics($context));
    }

    /**
     * @Route("/api/_action/bow-auto-links/tag-priority/{tagId}", name="api.action.bow.auto.links.tag.priority", methods={"POST"})
     */
    public function updateTagPriority(string $tagId, Request $request, Context $context): JsonResponse
    {
        $priority = (float) $request->request->get('priority', 1.0);
        $this->tagManagementService->updateTagPriority($tagId, $priority, $context);
        
        return new JsonResponse(['success' => true]);
    }

    /**
     * @Route("/api/_action/bow-auto-links/log-stats", name="api.action.bow.auto.links.log.stats", methods={"GET"})
     */
    public function getLogStats(): JsonResponse
    {
        return new JsonResponse($this->logger->getLogStats());
    }
}

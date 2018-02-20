<?php
namespace Ttree\ContentRepositoryImporter\Service;

use Neos\ContentRepository\Domain\Model\NodeInterface;
use Neos\ContentRepository\Domain\Service\Context;
use Neos\Eel\FlowQuery\FlowQuery;
use Neos\Neos\Domain\Service\ContentContextFactory;
use Ttree\ContentRepositoryImporter\Domain\Model\ProviderPropertyValidity;
use Neos\Flow\Annotations as Flow;

class ContextSwitcher
{
    /**
     * @Flow\Inject
     * @var ContentContextFactory
     */
    protected $contextFactory;

    /**
     * @var NodeInterface
     */
    private $node;

    public function __construct(NodeInterface $node)
    {
        $this->node = $node;
    }

    /**
     * @param array $dimensions
     * @param string $workspaceName
     * @return NodeInterface|null
     */
    public function to(array $dimensions, $workspaceName = 'live')
    {
        $context = $this->createContext($dimensions, $workspaceName);
        return $context->adoptNode($this->node);
    }

    /**
     * Create a context with the given workspace and dimensions
     *
     * @param array $dimensions
     * @param string $workspaceName
     * @return Context
     */
    protected function createContext(array $dimensions, $workspaceName)
    {
        return $this->contextFactory->create(array(
            'workspaceName' => $workspaceName,
            'dimensions' => $dimensions
        ));
    }
}

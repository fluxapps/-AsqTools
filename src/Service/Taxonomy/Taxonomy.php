<?php
declare(strict_types = 1);

namespace Fluxlabs\Assessment\Tools\Service\Taxonomy;

use ilObjTaxonomy;
use ilTaxonomyNode;
use ilTaxonomyTree;
use srag\asq\Application\Exception\AsqException;

/**
 * Class Taxonomy
 *
 * @package Fluxlabs\Assessment\Tools
 *
 * @author Fluxlabs AG - Adrian Lüthi <adi@fluxlabs.ch>
 */
class Taxonomy
{
    private ?ilObjTaxonomy $taxonomy = null;
    private ilTaxonomyTree $tree;

    private ?int $taxonomy_id;
    private ?array $node_mapping = null;

    public function __construct(?int $taxonomy_id = null)
    {
        $this->taxonomy_id = $taxonomy_id;
    }

    private function loadTaxonomy() : void
    {
        if ($this->taxonomy_id === null) {
            throw new AsqException("Need to know which taxonomy to load");
        }

        if ($this->taxonomy !== null) {
            //no need to load if already loaded
            return;
        }

        $this->taxonomy = new ilObjTaxonomy($this->taxonomy_id);
        $this->tree = $this->taxonomy->getTree();
    }

    public function createNew(string $title, string $description) : int
    {
        $taxonomy = new ilObjTaxonomy();
        $taxonomy->setTitle($title);
        $taxonomy->setDescription($description);
        $this->taxonomy_id = intval($taxonomy->create());
        return $this->taxonomy_id;
    }

    public function createNewNode(int $parent_id, string $title) : void
    {
        $this->loadTaxonomy();

        $node = new ilTaxonomyNode();
        $node->setTitle($title);
        $node->setTaxonomyId($this->taxonomy_id);
        $node->create();
        $this->taxonomy->getTree()->insertNode($node->getId(), $parent_id);
    }

    public function updateNode(int $id, string $title) : void
    {
        $node = new ilTaxonomyNode($id);
        $node->setTitle($title);
        $node->update();
    }

    public function deleteNode(int $id) : void
    {
        $this->loadTaxonomy();

        $node = new ilTaxonomyNode($id);

        $this->taxonomy->getTree()->deleteNode($this->tree->getTreeId(), $node->getId());

        $node->delete();
    }

    public function getTaxonomyWithChildren(int $node_id) : array
    {
        $taxonomies = [$node_id];

        foreach ($this->getNodeMapping() as $node) {
            $parent_id  =intval($node['parent']);
            if (in_array($parent_id, $taxonomies)) {
                $taxonomies[] = intval($node['obj_id']);
            }
        }

        return $taxonomies;
    }

    public function getNodeMapping() : array
    {
        if ($this->node_mapping === null) {
            $this->loadTaxonomy();
            $root_id = $this->tree->readRootId();
            $this->node_mapping[] = $this->tree->getNodeData($root_id);
            $this->processNode($root_id);
        }

        return $this->node_mapping;
    }

    private function processNode(string $node_id) : void
    {
        foreach ($this->tree->getChilds($node_id) as $node) {
            $this->node_mapping[] = $node;
            $this->processNode($node['obj_id']);
        }
    }
}
<?php
declare(strict_types=1);

class TreeNode
{
    public $data = null;
    public $children = [];

    public function __construct(string $data = null)
    {
        $this->data = $data;
    }

    public function addChildren(TreeNode $treeNode)
    {
        $this->children[] = $treeNode;
    }
}

class Tree
{
    public $root = null;

    public function __construct(TreeNode $treeNode)
    {
        $this->root = $treeNode;
    }

    public function BFS(TreeNode $treeNode): SplQueue
    {
        $queue = new SplQueue();
        $visited = new SplQueue();
        $queue->enqueue($treeNode);
        while (!$queue->isEmpty()) {
            $current = $queue->dequeue();
            $visited->enqueue($current);
            foreach ($current->children as $children) {
                $queue->enqueue($children);
            }
        }
        return $visited;
    }
}

//new TreeNode('8,3,10,1,6,14,4,7,13');
$tree = new Tree(new TreeNode('8,3,10,1,6,14,4,7,13'));
var_dump($tree->BFS(new TreeNode('8,3,10,1,6,14,4,7,13')));

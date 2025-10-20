<?php

namespace App\Services\DecisionTree;

class Predictor
{
    protected $tree;

    public function __construct(array $tree)
    {
        $this->tree = $tree;
    }

    public function predict(array $input)
    {
        return $this->traverse($this->tree, $input);
    }

    protected function traverse($node, $input)
    {
        if ($node['type'] === 'leaf') {
            return $node['label'];
        }

        if ($node['type'] === 'numeric') {
            $attr = $node['attribute'];
            $threshold = $node['threshold'];

            if (!isset($input[$attr])) {
                return null;
            }

            if ($input[$attr] <= $threshold) {
                return $this->traverse($node['left'], $input);
            } else {
                return $this->traverse($node['right'], $input);
            }
        }

        if ($node['type'] === 'node') {
            $attr = $node['attribute'];
            $val = $input[$attr] ?? null;
            if (isset($node['branches'][$val])) {
                return $this->traverse($node['branches'][$val], $input);
            } else {
                // fallback ke mayoritas cabang
                return $this->fallbackLabel($node['branches']);
            }
        }

        return null;
    }

    protected function fallbackLabel($branches)
    {
        $labels = [];
        foreach ($branches as $branch) {
            if ($branch['type'] === 'leaf') {
                $labels[] = $branch['label'];
            }
        }

        if (empty($labels)) return null;

        $counts = array_count_values($labels);
        arsort($counts);
        return array_key_first($counts);
    }
}
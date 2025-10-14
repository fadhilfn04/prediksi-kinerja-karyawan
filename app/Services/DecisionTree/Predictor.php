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
        // Kalau node sudah berupa string → ini leaf
        if (is_string($node)) {
            return $node;
        }

        $attribute = $node['attribute'] ?? null;

        if (!$attribute || !isset($input[$attribute])) {
            // Jika atribut tidak ada di input → fallback majority
            return 'Tidak diketahui';
        }

        $value = $input[$attribute];

        if (isset($node['branches'][$value])) {
            return $this->traverse($node['branches'][$value], $input);
        } else {
            // Kalau nilai tidak cocok dengan cabang → fallback
            return 'Tidak diketahui';
        }
    }
}
<?php

namespace App\Services\DecisionTree;

class C45
{
    protected $data;
    protected $target;

    public function __construct(array $data, string $target)
    {
        $this->data = $data;
        $this->target = $target;
    }

    public function train(array $attributes)
    {
        return $this->buildTree($this->data, $attributes);
    }

    protected function buildTree(array $data, array $attributes)
    {
        $labels = array_column($data, $this->target);
        $uniqueLabels = array_unique($labels);

        if (count($uniqueLabels) === 1) {
            return [
                'type' => 'leaf',
                'label' => $uniqueLabels[0]
            ];
        }

        if (empty($attributes)) {
            return [
                'type' => 'leaf',
                'label' => $this->majorityLabel($labels)
            ];
        }

        $best = $this->chooseBestAttribute($data, $attributes);

        if (!$best) {
            return [
                'type' => 'leaf',
                'label' => $this->majorityLabel($labels)
            ];
        }

        $tree = [
            'type' => 'node',
            'attribute' => $best['attribute'],
        ];

        if ($best['type'] === 'numeric') {
            $tree['type'] = 'numeric';
            $tree['threshold'] = $best['threshold'];

            $leftSplit = array_filter($data, fn($row) => $row[$best['attribute']] <= $best['threshold']);
            $rightSplit = array_filter($data, fn($row) => $row[$best['attribute']] > $best['threshold']);

            $tree['left'] = $this->buildTree($leftSplit, $attributes);
            $tree['right'] = $this->buildTree($rightSplit, $attributes);
        } else {
            $tree['branches'] = [];
            foreach ($best['values'] as $val) {
                $subset = array_filter($data, fn($row) => $row[$best['attribute']] == $val);
                $tree['branches'][$val] = $this->buildTree($subset, array_diff($attributes, [$best['attribute']]));
            }
        }

        return $tree;
    }

    protected function chooseBestAttribute(array $data, array $attributes)
    {
        $baseEntropy = $this->entropy($data);
        $bestGain = 0;
        $best = null;

        foreach ($attributes as $attribute) {
            $values = array_column($data, $attribute);

            if ($this->isNumericArray($values)) {
                $thresholds = $this->generateThresholds($values);
                foreach ($thresholds as $t) {
                    $gain = $this->informationGainNumeric($data, $attribute, $t, $baseEntropy);
                    if ($gain > $bestGain) {
                        $bestGain = $gain;
                        $best = [
                            'attribute' => $attribute,
                            'type' => 'numeric',
                            'threshold' => $t
                        ];
                    }
                }
            } else {
                $gain = $this->informationGainCategorical($data, $attribute, $baseEntropy);
                if ($gain > $bestGain) {
                    $bestGain = $gain;
                    $best = [
                        'attribute' => $attribute,
                        'type' => 'categorical',
                        'values' => array_unique($values)
                    ];
                }
            }
        }

        return $best;
    }

    protected function entropy(array $data)
    {
        $total = count($data);
        if ($total === 0) return 0;

        $counts = array_count_values(array_column($data, $this->target));
        $entropy = 0;

        foreach ($counts as $count) {
            $p = $count / $total;
            $entropy -= $p * log($p, 2);
        }

        return $entropy;
    }

    protected function informationGainCategorical(array $data, string $attribute, float $baseEntropy)
    {
        $total = count($data);
        $values = array_unique(array_column($data, $attribute));
        $newEntropy = 0;

        foreach ($values as $val) {
            $subset = array_filter($data, fn($row) => $row[$attribute] == $val);
            $p = count($subset) / $total;
            $newEntropy += $p * $this->entropy($subset);
        }

        return $baseEntropy - $newEntropy;
    }

    protected function informationGainNumeric(array $data, string $attribute, $threshold, float $baseEntropy)
    {
        $total = count($data);
        $left = array_filter($data, fn($row) => $row[$attribute] <= $threshold);
        $right = array_filter($data, fn($row) => $row[$attribute] > $threshold);

        $leftEntropy = $this->entropy($left);
        $rightEntropy = $this->entropy($right);

        $newEntropy = (count($left) / $total) * $leftEntropy + (count($right) / $total) * $rightEntropy;
        return $baseEntropy - $newEntropy;
    }

    protected function generateThresholds(array $values)
    {
        $values = array_unique(array_map('floatval', $values));
        sort($values);
        $thresholds = [];

        for ($i = 0; $i < count($values) - 1; $i++) {
            $thresholds[] = ($values[$i] + $values[$i + 1]) / 2;
        }

        return $thresholds;
    }

    protected function isNumericArray(array $arr)
    {
        foreach ($arr as $v) {
            if (!is_numeric($v)) return false;
        }
        return true;
    }

    protected function majorityLabel(array $labels)
    {
        $counts = array_count_values($labels);
        arsort($counts);
        return array_key_first($counts);
    }
}
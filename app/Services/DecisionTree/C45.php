<?php

namespace App\Services\DecisionTree;

class C45
{
    protected $data;
    protected $targetAttribute;

    public function __construct(array $data, string $targetAttribute)
    {
        $this->data = $data;
        $this->targetAttribute = $targetAttribute;
    }

    public function train(array $attributes)
    {
        return $this->buildTree($this->data, $attributes);
    }

    protected function buildTree(array $data, array $attributes)
    {
        $targetValues = array_column($data, $this->targetAttribute);
        $uniqueTargets = array_unique($targetValues);

        // 1. Semua target sama → daun
        if (count($uniqueTargets) === 1) {
            return $uniqueTargets[0];
        }

        // 2. Atribut habis → mayoritas
        if (empty($attributes)) {
            return $this->majorityValue($targetValues);
        }

        // 3. Pilih atribut terbaik dengan Gain Ratio
        $bestAttribute = $this->chooseBestAttribute($data, $attributes);

        if ($bestAttribute === null) {
            return $this->majorityValue($targetValues);
        }

        $tree = [
            'attribute' => $bestAttribute,
            'branches' => []
        ];

        // 4. Buat cabang untuk setiap nilai atribut
        $attributeValues = array_unique(array_column($data, $bestAttribute));

        foreach ($attributeValues as $value) {
            $subset = array_filter($data, fn($row) => $row[$bestAttribute] == $value);

            if (empty($subset)) {
                $tree['branches'][$value] = $this->majorityValue($targetValues);
            } else {
                $remainingAttributes = array_diff($attributes, [$bestAttribute]);
                $tree['branches'][$value] = $this->buildTree(array_values($subset), $remainingAttributes);
            }
        }

        return $tree;
    }

    protected function chooseBestAttribute(array $data, array $attributes)
    {
        $baseEntropy = $this->entropy($data);
        $bestGainRatio = -INF;
        $bestAttribute = null;

        foreach ($attributes as $attribute) {
            $gain = $baseEntropy - $this->conditionalEntropy($data, $attribute);
            $splitInfo = $this->splitInformation($data, $attribute);

            // Hindari pembagian dengan nol
            if ($splitInfo == 0) {
                continue;
            }

            $gainRatio = $gain / $splitInfo;

            if ($gainRatio > $bestGainRatio) {
                $bestGainRatio = $gainRatio;
                $bestAttribute = $attribute;
            }
        }

        return $bestAttribute;
    }

    protected function entropy(array $data)
    {
        $targetCounts = [];
        foreach ($data as $row) {
            $value = $row[$this->targetAttribute];
            $targetCounts[$value] = ($targetCounts[$value] ?? 0) + 1;
        }

        $entropy = 0;
        $total = count($data);
        foreach ($targetCounts as $count) {
            $p = $count / $total;
            $entropy -= $p * log($p, 2);
        }

        return $entropy;
    }

    protected function conditionalEntropy(array $data, string $attribute)
    {
        $subsets = [];
        foreach ($data as $row) {
            $value = $row[$attribute];
            $subsets[$value][] = $row;
        }

        $total = count($data);
        $entropy = 0;

        foreach ($subsets as $subset) {
            $subsetSize = count($subset);
            $entropy += ($subsetSize / $total) * $this->entropy($subset);
        }

        return $entropy;
    }

    protected function splitInformation(array $data, string $attribute)
    {
        $valueCounts = [];
        foreach ($data as $row) {
            $value = $row[$attribute];
            $valueCounts[$value] = ($valueCounts[$value] ?? 0) + 1;
        }

        $total = count($data);
        $splitInfo = 0;

        foreach ($valueCounts as $count) {
            $p = $count / $total;
            $splitInfo -= $p * log($p, 2);
        }

        return $splitInfo;
    }

    protected function majorityValue(array $values)
    {
        $counts = array_count_values($values);
        arsort($counts);
        return array_key_first($counts);
    }
}
<?php

namespace App\Services\MergeRules;

class UnionArrayMergeRule implements MergeRuleContract
{
    /**
     * Merge 2 arrays
     */
    public function merge(mixed $currentValue, mixed $rawValue): array
    {
        return array_merge(
            $currentValue ?? [],
            $rawValue ?? []
        );
    }
}

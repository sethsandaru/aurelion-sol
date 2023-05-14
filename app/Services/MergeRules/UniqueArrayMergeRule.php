<?php

namespace App\Services\MergeRules;

class UniqueArrayMergeRule implements MergeRuleContract
{
    /**
     * Merge 2 arrays and remove the duplicated values.
     */
    public function merge(mixed $currentValue, mixed $rawValue): array
    {
        $mergedArray = array_merge(
            $currentValue ?? [],
            $rawValue ?? []
        );

        return collect($mergedArray)
            ->unique() // remove unique values
            ->values() // reindex array
            ->toArray(); // parse to array
    }
}

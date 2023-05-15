<?php

namespace App\Services\MergeRules;

use Illuminate\Support\Str;

class UniqueArrayMergeRule implements MergeRuleContract
{
    /**
     * Merge 2 arrays and remove the duplicated values.
     */
    public function merge(mixed $currentValue, mixed $rawValue): array
    {
        return $this->mergeAndRemoveDuplicated(
            $currentValue ?? [],
            $rawValue ?? []
        );
    }

    private function mergeAndRemoveDuplicated(array $mainValues, array $rawValues): array
    {
        $totalValues = $mainValues;

        foreach ($rawValues as $rawValue) {
            foreach ($totalValues as $mainValue) {
                if (in_array($rawValue, $totalValues)) {
                    break;
                }

                if (Str::contains($mainValue, $rawValue, true)
                    || Str::contains($rawValue, $mainValue, true)) {
                    continue;
                }

                $totalValues[] = $rawValue;
                break;
            }
        }

        return $totalValues;
    }
}

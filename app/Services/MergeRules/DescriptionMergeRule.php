<?php

namespace App\Services\MergeRules;

class DescriptionMergeRule implements MergeRuleContract
{
    public function merge(mixed $currentValue, mixed $rawValue): string
    {
        $stringRawValue = $rawValue ?? '';
        if (!$stringRawValue) {
            return $currentValue;
        }

        // first, currentValue is not valid, then the rawValue is always valid
        if (!$currentValue) {
            return $stringRawValue;
        }

        // second, length comparison, greedy
        return strlen($currentValue) > strlen($rawValue)
            ? $currentValue
            : $rawValue;
    }
}

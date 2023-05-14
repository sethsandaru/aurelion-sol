<?php

namespace App\Services\MergeRules;

class NullCoalesceMergeRule implements MergeRuleContract
{
    /**
     * Simple merge, if value is not null, no replace
     */
    public function merge(mixed $currentValue, mixed $rawValue): mixed
    {
        return $currentValue ?? $rawValue;
    }
}

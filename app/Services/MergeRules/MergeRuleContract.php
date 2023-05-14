<?php

namespace App\Services\MergeRules;

interface MergeRuleContract
{
    public function merge(mixed $currentValue, mixed $rawValue): mixed;
}

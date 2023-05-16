<?php

namespace App\Services\MergeRules;

enum MergeType
{
    case NULL_COALESCE;
    case DESCRIPTION;
    case UNION_ARRAY_MERGE;
    case UNIQUE_ARRAY_MERGE;
}

<?php

namespace App\Services\ETL;

use Illuminate\Support\Collection;
use LogicException;

class RawHotels extends Collection
{
    public const ENTITY = RawHotel::class;

    private function validateInstance($item): void
    {
        if ($item instanceof self::ENTITY) {
            return;
        }

        throw new LogicException('The given parameter is not an instance of ' . self::ENTITY);
    }

    public function add($item): self
    {
        $this->validateInstance($item);

        return parent::add($item);
    }

    public function push(...$values): self
    {
        collect($values)->each($this->add(...));

        return $this;
    }
}

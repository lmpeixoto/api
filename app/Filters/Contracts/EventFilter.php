<?php

declare(strict_types=1);

namespace VOSTPT\Filters\Contracts;

interface EventFilter extends Filter, GeoLocator
{
    /**
     * Include types for filtering.
     *
     * @param int[] $types
     *
     * @return void
     */
    public function withTypes(...$types): void;

    /**
     * Include parishes for filtering.
     *
     * @param int[] $parishes
     *
     * @return void
     */
    public function withParishes(...$parishes): void;
}

<?php

declare(strict_types=1);

namespace VOSTPT\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode as Middleware;

class CheckForMaintenanceMode extends Middleware
{
    /**
     * {@inheritDoc}
     */
    protected $except = [
        //
    ];
}

<?php

declare(strict_types=1);

namespace Sigmie\Search\Docs;

use Sigmie\Search\BaseService;

class Service extends BaseService
{
    public function callCal(...$args)
    {
        return $this->call(...$args);
    }
}

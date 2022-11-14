<?php

declare(strict_types=1);

namespace Ofload\Butn;

class Client
{
    public function fetchTransaction(): string
    {
        return 'Foo Transaction';
    }

    public function packageUpdated(): string
    {
        return 'package updated';
    }
}
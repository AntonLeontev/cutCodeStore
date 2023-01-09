<?php

namespace Src\Domains\Auth\Contracts;

use Src\Domains\Auth\DTOs\NewUserDTO;

interface RegisterNewUserContract
{
    public function __invoke(NewUserDTO $data);
}

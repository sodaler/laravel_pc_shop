<?php

namespace App\Contracts;

interface RegisterNewUserContract
{
    public function __invoke(string $name, string $email, string $password);
}

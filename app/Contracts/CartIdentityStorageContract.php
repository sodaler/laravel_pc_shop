<?php

namespace App\Contracts;

interface CartIdentityStorageContract
{
    public function get(): string;
}

<?php

namespace App\Support\StorageIdentities;

use App\Contracts\CartIdentityStorageContract;

class SessionIdentityStorage implements CartIdentityStorageContract
{
    public function get(): string
    {
        return session()->getId();
    }
}

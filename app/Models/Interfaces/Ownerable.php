<?php

namespace App\Models\Interfaces;

use App\Models\User;

interface Ownerable
{
    /**
     * @return User
     */
    public function getOwner(): User;
}

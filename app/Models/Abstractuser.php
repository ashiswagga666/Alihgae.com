<?php

namespace App\Models;
abstract class AbstractUser
{
    // Method abstrak
    abstract public function dashboard(): string;
    abstract public function getRole(): string;

    // Method konkret
    public function getInfo(): string
    {
        return "Role: " . $this->getRole();
    }
}
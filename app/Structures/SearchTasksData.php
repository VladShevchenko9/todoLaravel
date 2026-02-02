<?php

namespace App\Structures;

use App\Models\User;

class SearchTasksData
{
    private User $user;

    private string $description = '';

    private int $priority = 0;

    private ?bool $status = null;
    private bool $exactMatch = true;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = trim($description);
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): void
    {
        $this->priority = $priority;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(?bool $status): void
    {
        $this->status = $status;
    }

    public function getExactMatch(): bool
    {
        return $this->exactMatch;
    }

    public function setExactMatch(bool $exactMatch): void
    {
        $this->exactMatch = $exactMatch;
    }
}

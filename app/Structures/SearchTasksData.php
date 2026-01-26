<?php

namespace App\Structures;

class SearchTasksData
{
    public int $userId;

    public string $description = '';

    public int $priority = 0;

    public ?bool $status = null;
    public bool $exactMatch = true;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }
}

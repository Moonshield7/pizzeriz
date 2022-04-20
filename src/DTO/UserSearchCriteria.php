<?php

declare(strict_types=1);

namespace App\DTO;

class UserSearchCriteria
{
    public int $limit = 15;
    public int $page = 1;
    public string $orderBy = 'id';
    public string $direction = 'DESC';
}

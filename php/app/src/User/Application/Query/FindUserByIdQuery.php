<?php
declare(strict_types=1);

namespace App\User\Application\Query;

use App\User\Domain\ValueObject\UserId;
use NinjaBuggs\ServiceBus\Query\QueryInterface;

class FindUserByIdQuery implements QueryInterface
{
    private $id;

    public function __construct(string $id)
    {
        $this->id = new UserId($id);
    }

    public function getId(): UserId
    {
        return $this->id;
    }
}
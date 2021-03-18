<?php
declare(strict_types=1);

namespace App\User\Application\Command;

use App\User\Domain\ValueObject\UserId;
use NinjaBuggs\ServiceBus\Command\CommandInterface;

class DeleteUserCommand implements CommandInterface
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

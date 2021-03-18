<?php
declare(strict_types=1);

namespace App\User\Application\Command;

use App\User\Domain\ValueObject\UserId;
use NinjaBuggs\ServiceBus\Command\CommandInterface;

class UpdateUserCommand implements CommandInterface
{
    private $id;
    private $userName;
    private $text;

    public function __construct(string $id, string $userName, string $text)
    {
        $this->id = new UserId($id);
        $this->text = $text;
        $this->userName = $userName;
    }

    public function getId(): UserId
    {
        return $this->id;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function getText(): string
    {
        return $this->text;
    }
}

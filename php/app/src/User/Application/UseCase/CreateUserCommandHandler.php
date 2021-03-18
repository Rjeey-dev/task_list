<?php
declare(strict_types=1);

namespace App\User\Application\UseCase;

use App\User\Application\Command\CreateUserCommand;
use App\User\Domain\Entity\User;
use App\User\Domain\Repository\UsersRepositoryInterface;
use NinjaBuggs\ServiceBus\Command\UseCaseInterface;
use NinjaBuggs\ServiceBus\TransactionalHandlerInterface;

class CreateUserCommandHandler implements UseCaseInterface, TransactionalHandlerInterface
{
    private $usersRepository;

    public function __construct(UsersRepositoryInterface $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function __invoke(CreateUserCommand $command): void
    {
        $user = new User($command->getId(), $command->getUserName(), $command->getText());

        $this->usersRepository->add($user);
    }
}
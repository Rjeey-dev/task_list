<?php
declare(strict_types=1);

namespace App\User\Application\UseCase;

use App\User\Application\Command\DeleteUserCommand;
use App\User\Domain\Repository\UsersRepositoryInterface;
use NinjaBuggs\ServiceBus\Command\UseCaseInterface;
use NinjaBuggs\ServiceBus\TransactionalHandlerInterface;

class DeleteUserCommandHandler implements UseCaseInterface, TransactionalHandlerInterface
{
    private $usersRepository;

    public function __construct(UsersRepositoryInterface $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function __invoke(DeleteUserCommand $command): void
    {
        $user = $this->usersRepository->get($command->getId());

        $user->delete();

        $this->usersRepository->remove($user);
    }
}
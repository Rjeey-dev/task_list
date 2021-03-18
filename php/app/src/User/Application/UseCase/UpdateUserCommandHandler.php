<?php
declare(strict_types=1);

namespace App\User\Application\UseCase;

use App\User\Application\Command\UpdateUserCommand;
use App\User\Domain\Repository\UsersRepositoryInterface;
use NinjaBuggs\ServiceBus\Command\UseCaseInterface;
use NinjaBuggs\ServiceBus\TransactionalHandlerInterface;

class UpdateUserCommandHandler implements UseCaseInterface, TransactionalHandlerInterface
{
    private $usersRepository;

    public function __construct(UsersRepositoryInterface $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function __invoke(UpdateUserCommand $command): void
    {
        $user = $this->usersRepository->get($command->getId());

        $user->update($command->getText(),$command->getUserName());

        $this->usersRepository->add($user);
    }
}

<?php
declare(strict_types=1);

namespace App\Task\Application\UseCase;

use App\Task\Application\Command\DeleteTaskCommand;
use App\Task\Domain\Repository\TasksRepositoryInterface;
use NinjaBuggs\ServiceBus\Command\UseCaseInterface;
use NinjaBuggs\ServiceBus\TransactionalHandlerInterface;

class DeleteTaskCommandHandler implements UseCaseInterface, TransactionalHandlerInterface
{
    private $usersRepository;

    public function __construct(TasksRepositoryInterface $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function __invoke(DeleteTaskCommand $command): void
    {
        $user = $this->usersRepository->get($command->getId());

        $user->delete();

        $this->usersRepository->remove($user);
    }
}
<?php
declare(strict_types=1);

namespace App\Task\Application\UseCase;

use App\Task\Application\Command\UpdateTaskCommand;
use App\Task\Domain\Repository\TasksRepositoryInterface;
use NinjaBuggs\ServiceBus\Command\UseCaseInterface;
use NinjaBuggs\ServiceBus\TransactionalHandlerInterface;

class UpdateTaskCommandHandler implements UseCaseInterface, TransactionalHandlerInterface
{
    private $usersRepository;

    public function __construct(TasksRepositoryInterface $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function __invoke(UpdateTaskCommand $command): void
    {
        $user = $this->usersRepository->get($command->getId());

        $user->update($command->getText(),$command->getUserName());

        $this->usersRepository->add($user);
    }
}

<?php
declare(strict_types=1);

namespace App\Task\Application\UseCase;

use App\Task\Application\Command\CreateTaskCommand;
use App\Task\Domain\Entity\Task;
use App\Task\Domain\Repository\TasksRepositoryInterface;
use NinjaBuggs\ServiceBus\Command\UseCaseInterface;
use NinjaBuggs\ServiceBus\TransactionalHandlerInterface;

class CreateTaskCommandHandler implements UseCaseInterface, TransactionalHandlerInterface
{
    private $usersRepository;

    public function __construct(TasksRepositoryInterface $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function __invoke(CreateTaskCommand $command): void
    {
        $user = new Task($command->getId(), $command->getUserName(), $command->getText());

        $this->usersRepository->add($user);
    }
}
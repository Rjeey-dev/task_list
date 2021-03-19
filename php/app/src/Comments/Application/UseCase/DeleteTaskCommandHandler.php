<?php
declare(strict_types=1);

namespace App\Comments\Application\UseCase;

use App\Comments\Application\Command\DeleteCommentsCommand;
use App\Comments\Domain\Repository\CommentsRepositoryInterface;
use NinjaBuggs\ServiceBus\Command\UseCaseInterface;
use NinjaBuggs\ServiceBus\TransactionalHandlerInterface;

class DeleteTaskCommandHandler implements UseCaseInterface, TransactionalHandlerInterface
{
    private $usersRepository;

    public function __construct(CommentsRepositoryInterface $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function __invoke(DeleteCommentsCommand $command): void
    {
        $user = $this->usersRepository->get($command->getId());

        $user->delete();

        $this->usersRepository->remove($user);
    }
}
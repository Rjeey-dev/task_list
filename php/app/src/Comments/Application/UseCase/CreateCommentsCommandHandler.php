<?php
declare(strict_types=1);

namespace App\Comments\Application\UseCase;

use App\Comments\Application\Command\CreateCommentsCommand;
use App\Comments\Domain\Entity\Comment;
use App\Comments\Domain\Repository\CommentsRepositoryInterface;
use NinjaBuggs\ServiceBus\Command\UseCaseInterface;
use NinjaBuggs\ServiceBus\TransactionalHandlerInterface;

class CreateCommentsCommandHandler implements UseCaseInterface, TransactionalHandlerInterface
{
    private $usersRepository;

    public function __construct(CommentsRepositoryInterface $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function __invoke(CreateCommentsCommand $command): void
    {
        $user = new Comment($command->getId(), $command->getUserName(), $command->getText());

        $this->usersRepository->add($user);
    }
}
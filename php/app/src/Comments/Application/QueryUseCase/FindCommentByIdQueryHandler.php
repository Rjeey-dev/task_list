<?php
declare(strict_types=1);

namespace App\Comments\Application\QueryUseCase;

use App\Comments\Application\Query\FindCommentByIdQuery;
use App\Comments\Domain\DataProvider\CommentDataProviderInterface;
use App\Comments\Domain\DTO\Comment;
use App\Comments\Domain\Exception\CommentNotFoundException;
use NinjaBuggs\ServiceBus\Query\QueryUseCaseInterface;

class FindCommentByIdQueryHandler implements QueryUseCaseInterface
{
    private $usersDataProvider;

    public function __construct(CommentDataProviderInterface $usersDataProvider)
    {
        $this->usersDataProvider = $usersDataProvider;
    }

    public function __invoke(FindCommentByIdQuery $query): ?Comment
    {
        try {
            return $this->usersDataProvider->findUser($query->getId());
        } catch (CommentNotFoundException $e) {
            return null;
        }
    }
}
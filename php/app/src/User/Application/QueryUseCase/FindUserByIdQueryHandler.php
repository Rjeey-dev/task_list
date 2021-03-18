<?php
declare(strict_types=1);

namespace App\User\Application\QueryUseCase;

use App\User\Application\Query\FindUserByIdQuery;
use App\User\Domain\DataProvider\UsersDataProviderInterface;
use App\User\Domain\DTO\User;
use App\User\Domain\Exception\UserNotFoundException;
use NinjaBuggs\ServiceBus\Query\QueryUseCaseInterface;

class FindUserByIdQueryHandler implements QueryUseCaseInterface
{
    private $usersDataProvider;

    public function __construct(UsersDataProviderInterface $usersDataProvider)
    {
        $this->usersDataProvider = $usersDataProvider;
    }

    public function __invoke(FindUserByIdQuery $query): ?User
    {
        try {
            return $this->usersDataProvider->findUser($query->getId());
        } catch (UserNotFoundException $e) {
            return null;
        }
    }
}
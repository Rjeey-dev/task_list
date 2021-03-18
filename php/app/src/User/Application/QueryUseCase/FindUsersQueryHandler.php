<?php
declare(strict_types=1);

namespace App\User\Application\QueryUseCase;

use App\User\Application\Query\FindUsersQuery;
use App\User\Domain\DataProvider\UsersDataProviderInterface;
use App\User\Domain\DTO\UsersList;
use NinjaBuggs\ServiceBus\Query\QueryUseCaseInterface;

class FindUsersQueryHandler implements QueryUseCaseInterface
{
    private $userDataProvider;

    public function __construct(UsersDataProviderInterface $usersDataProvider)
    {
        $this->userDataProvider = $usersDataProvider;
    }

    public function __invoke(FindUsersQuery $query): UsersList
    {
        return $this->userDataProvider->findUsers($query->getOffset(), $query->getLimit(), $query->getOrder());
    }
}
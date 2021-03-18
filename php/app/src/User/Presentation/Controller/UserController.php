<?php
declare(strict_types=1);

namespace App\User\Presentation\Controller;

use App\Kernel\Api\Controller\ApiController;
use App\Kernel\Api\Response\ApiResponse;
use App\User\Application\Command\CreateUserCommand;
use App\User\Application\Command\UpdateUserCommand;
use App\User\Application\Command\DeleteUserCommand;
use App\User\Application\Query\FindUserByIdQuery;
use App\User\Application\Query\FindUsersQuery;
use App\User\Domain\DTO\UsersList;
use App\User\Domain\Exception\ValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

class UserController extends ApiController
{
    /**
     * @Route("/users", name="users", methods={"GET"})
     */
    public function list(Request $request): Response
    {
        try {
            /** @var UsersList $usersList */
            $usersList = $this->queryBus->handle(new FindUsersQuery(
                $request->query->get('offset') !== null ? (int)$request->query->get('offset') : null,
                $request->query->get('limit') !== null ? (int)$request->query->get('limit') : null,
                $request->query->get('order') !== null ? (string)$request->query->get('order') : null
            ));

            return $this->buildSerializedListResponse(
                $usersList->getUsers(),
                $usersList->getTotalCount(),
                ['users-list']
            );
        } catch (ValidationException $e) {
            return $this->buildFailResponse(ApiResponse::ERROR_VALIDATION_FAILED);
        } catch (\Throwable $e) {
            return $this->buildFailResponse();
        }
    }

    /**
     * @Route ("/users", name="create_user", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        try {
            $data = json_decode($request->getContent(), true);

            $command = new CreateUserCommand(
                (string)$data['text'],
                (string)$data['name']
            );

            $this->commandBus->handle($command);

            return $this->buildSerializedResponse(
                $this->queryBus->handle(new FindUserByIdQuery($command->getId()->getId())),
                ['user-detail']
            );
        } catch (ValidationException $e) {
            return $this->buildFailResponse(ApiResponse::ERROR_VALIDATION_FAILED);
        } catch (\Throwable $e) {
            return $this->buildFailResponse($e->getMessage());
        }
    }

    /**
     * @Route("/users/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(string $id): Response
    {
        try {
            $command = new DeleteUserCommand($id);

            $this->commandBus->handle($command);

            return $this->buildSuccessResponse();
        } catch (\Throwable $e) {
            return $this->buildFailResponse($e->getMessage());
        }
    }

    /**
     * @Route("/users/{id}", name="user_update", methods={"PATCH"})
     */
    public function update(Request $request, string $id): Response
    {
        try {
            $data = json_decode($request->getContent(), true);

            $command = new UpdateUserCommand($id, (string) $data['text'], (string) $data['name']);

            $this->commandBus->handle($command);

            return $this->buildSerializedResponse(
                $this->queryBus->handle(new FindUserByIdQuery($id)),
                ['user-detail']
            );
        } catch (ValidationException $e) {
            return $this->buildFailResponse(ApiResponse::ERROR_VALIDATION_FAILED);
        } catch (\Throwable $e) {
            return $this->buildFailResponse($e->getMessage());
        }
    }
}
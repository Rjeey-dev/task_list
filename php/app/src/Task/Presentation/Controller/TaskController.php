<?php
declare(strict_types=1);

namespace App\Task\Presentation\Controller;

use App\Kernel\Api\Controller\ApiController;
use App\Kernel\Api\Response\ApiResponse;
use App\Task\Application\Command\CreateTaskCommand;
use App\Task\Application\Command\UpdateTaskCommand;
use App\Task\Application\Command\DeleteTaskCommand;
use App\Task\Application\Query\FindTaskByIdQuery;
use App\Task\Application\Query\FindTasksQuery;
use App\Task\Domain\DTO\TasksList;
use App\Task\Domain\Exception\ValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

class TaskController extends ApiController
{
    /**
     * @Route("/tasks", name="tasks", methods={"GET"})
     */
    public function list(Request $request): Response
    {
        try {
            /** @var TasksList $usersList */
            $usersList = $this->queryBus->handle(new FindTasksQuery(
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
     * @Route ("/tasks", name="create_user", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        try {
            $data = json_decode($request->getContent(), true);

            $command = new CreateTaskCommand(
                (string)$data['text'],
                (string)$data['name']
            );

            $this->commandBus->handle($command);

            return $this->buildSerializedResponse(
                $this->queryBus->handle(new FindTaskByIdQuery($command->getId()->getId())),
                ['user-detail']
            );
        } catch (ValidationException $e) {
            return $this->buildFailResponse(ApiResponse::ERROR_VALIDATION_FAILED);
        } catch (\Throwable $e) {
            return $this->buildFailResponse($e->getMessage());
        }
    }

    /**
     * @Route("/tasks/{id}", name="task_delete", methods={"DELETE"})
     */
    public function delete(string $id): Response
    {
        try {
            $command = new DeleteTaskCommand($id);

            $this->commandBus->handle($command);

            return $this->buildSuccessResponse();
        } catch (\Throwable $e) {
            return $this->buildFailResponse($e->getMessage());
        }
    }

    /**
     * @Route("/tasks/{id}", name="task_update", methods={"PATCH"})
     */
    public function update(Request $request, string $id): Response
    {
        try {
            $data = json_decode($request->getContent(), true);

            $command = new UpdateTaskCommand($id, (string) $data['text'], (string) $data['name']);

            $this->commandBus->handle($command);

            return $this->buildSerializedResponse(
                $this->queryBus->handle(new FindTaskByIdQuery($id)),
                ['user-detail']
            );
        } catch (ValidationException $e) {
            return $this->buildFailResponse(ApiResponse::ERROR_VALIDATION_FAILED);
        } catch (\Throwable $e) {
            return $this->buildFailResponse($e->getMessage());
        }
    }
}
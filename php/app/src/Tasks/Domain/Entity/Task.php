<?php
declare(strict_types=1);

namespace App\Tasks\Domain\Entity;

use App\Tasks\Domain\Event\TaskHasBeenCreatedEvent;
use App\Tasks\Domain\Event\TaskHasBeenUpdateEvent;
use App\Tasks\Domain\Event\TaskHasBeenDeletedEvent;
use App\Tasks\Domain\ValueObject\TaskId;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use NinjaBuggs\ServiceBus\Event\EventRecordableInterface;
use NinjaBuggs\ServiceBus\Event\EventRecordableTrait;

/**
 * @MongoDB\Document
 */
class Task implements EventRecordableInterface
{
    use EventRecordableTrait;

    /**
     * @MongoDB\Id(strategy="NONE", type="task:task_id")
     */
    private $id;

    /**
     * @MongoDB\Field(name="todo", type="string")
     */
    private $todo;

    /**
     * @MongoDB\Field(type="string")
     */
    private $doing;

    /**
     * @MongoDB\Field(type="string")
     */
    private $done;

    /**
     * @MongoDB\Field(type="date_immutable")
     */
    private $created;

    public function __construct(TaskId $id, string $todo, string $doing, string $done)
    {
        $this->id = $id;
        $this->todo = $todo;
        $this->doing = $doing;
        $this->done = $done;
        $this->created = new \DateTimeImmutable();

        $this->recordEvent(new TaskHasBeenCreatedEvent(
            $id->getId(),
            $todo,
            $doing,
            $done,
        ));
    }

    public function update(string $todo, string $doing, string $done): void
    {
        $this->todo = $todo;
        $this->doing = $doing;
        $this->done = $done;

        $this->recordEvent(new TaskHasBeenUpdateEvent(
            $this->id->getId(),
            $todo,
            $doing,
            $done,
        ));
    }

    public function delete(): void
    {
        $this->recordEvent(new TaskHasBeenDeletedEvent(
            $this->id->getId(),
            $this->todo,
            $this->doing,
            $this->done,
        ));
    }

}
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
     * @MongoDB\Field(name="name", type="string")
     */
    private $name;

    /**
     * @MongoDB\Field(name="status", type="string")
     */
    private $status;


    /**
     * @MongoDB\Field(type="date_immutable")
     */
    private $created;

    public function __construct(TaskId $id, string $name, string $status)
    {
        $this->id = $id;
        $this->name = $name;
        $this->status = $status;

        $this->created = new \DateTimeImmutable();

        $this->recordEvent(new TaskHasBeenCreatedEvent(
            $id->getId(),
            $name,
            $status,
        ));
    }

    public function update(string $name, string $status): void
    {
        $this->name = $name;
        $this->status = $status;

        $this->recordEvent(new TaskHasBeenUpdateEvent(
            $this->id->getId(),
            $name,
            $status,
        ));
    }

    public function delete(): void
    {
        $this->recordEvent(new TaskHasBeenDeletedEvent(
            $this->id->getId(),
            $this->name,
            $this->status,
        ));
    }
}
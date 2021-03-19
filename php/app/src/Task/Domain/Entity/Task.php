<?php
declare(strict_types=1);

namespace App\Task\Domain\Entity;

use App\Task\Domain\Event\TaskHasBeenCreatedEvent;
use App\Task\Domain\Event\TaskHasBeenUpdateEvent;
use App\Task\Domain\Event\TaskHasBeenDeletedEvent;
use App\Task\Domain\ValueObject\TaskId;
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
     * @MongoDB\Id(strategy="NONE", type="user:user_id")
     */
    private $id;

    /**
     * @MongoDB\Field(name="user_name", type="string")
     */
    private $userName;

    /**
     * @MongoDB\Field(type="string")
     */
    private $text;

    /**
     * @MongoDB\Field(type="date_immutable")
     */
    private $created;

    public function __construct(TaskId $id, string $userName, string $text)
    {
        $this->id = $id;
        $this->userName = $userName;
        $this->text = $text;
        $this->created = new \DateTimeImmutable();

        $this->recordEvent(new TaskHasBeenCreatedEvent(
            $id->getId(),
            $userName,
            $text
        ));
    }

    public function update(string $text, string $userName): void
    {
        $this->userName = $userName;
        $this->text = $text;

        $this->recordEvent(new TaskHasBeenUpdateEvent(
            $this->id->getId(),
            $userName,
            $text
        ));
    }

    public function delete(): void
    {
        $this->recordEvent(new TaskHasBeenDeletedEvent(
            $this->id->getId(),
            $this->userName,
            $this->text
        ));
    }

}
<?php
declare(strict_types=1);

namespace App\Comments\Domain\Entity;

use App\Comments\Domain\Event\CommentHasBeenCreatedEvent;
use App\Comments\Domain\Event\CommentHasBeenUpdateEvent;
use App\Comments\Domain\Event\CommentHasBeenDeletedEvent;
use App\Comments\Domain\ValueObject\CommentId;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use NinjaBuggs\ServiceBus\Event\EventRecordableInterface;
use NinjaBuggs\ServiceBus\Event\EventRecordableTrait;

/**
 * @MongoDB\Document
 */
class Comment implements EventRecordableInterface
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

    public function __construct(CommentId $id, string $userName, string $text)
    {
        $this->id = $id;
        $this->userName = $userName;
        $this->text = $text;
        $this->created = new \DateTimeImmutable();

        $this->recordEvent(new CommentHasBeenCreatedEvent(
            $id->getId(),
            $userName,
            $text
        ));
    }

    public function update(string $text, string $userName): void
    {
        $this->userName = $userName;
        $this->text = $text;

        $this->recordEvent(new CommentHasBeenUpdateEvent(
            $this->id->getId(),
            $userName,
            $text
        ));
    }

    public function delete(): void
    {
        $this->recordEvent(new CommentHasBeenDeletedEvent(
            $this->id->getId(),
            $this->userName,
            $this->text
        ));
    }

}
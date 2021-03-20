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
     * @MongoDB\Id(strategy="NONE", type="comment:comment_id")
     */
    private $id;

    /**
     * @MongoDB\Field(name="comment", type="string")
     */
    private $comment;

    /**
     * @MongoDB\Field(type="string")
     */
    private $text;

    /**
     * @MongoDB\Field(type="date_immutable")
     */
    private $created;

    public function __construct(CommentId $id, string $comment, string $text)
    {
        $this->id = $id;
        $this->comment = $comment;
        $this->text = $text;
        $this->created = new \DateTimeImmutable();

        $this->recordEvent(new CommentHasBeenCreatedEvent(
            $id->getId(),
            $comment,
            $text
        ));
    }

    public function update(string $text, string $comment): void
    {
        $this->comment = $comment;
        $this->text = $text;

        $this->recordEvent(new CommentHasBeenUpdateEvent(
            $this->id->getId(),
            $comment,
            $text
        ));
    }

    public function delete(): void
    {
        $this->recordEvent(new CommentHasBeenDeletedEvent(
            $this->id->getId(),
            $this->comment,
            $this->text
        ));
    }

}
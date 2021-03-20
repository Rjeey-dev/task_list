<?php
declare(strict_types=1);

namespace App\Comments\Domain\DTO;

use JMS\Serializer\Annotation as Serializer;

class Comment
{
    /**
     * @Serializer\SerializedName("id")
     * @Serializer\Type("string")
     * @Serializer\Groups({
     *     "comments-list",
     *     "comment-detail",
     * })
     */
    public $id;

    /**
     * @Serializer\SerializedName("task_id")
     * @Serializer\Type("string")
     * @Serializer\Groups({
     *     "comments-list",
     *     "comment-detail",
     * })
     */
    public $task_Id;

    /**
     * @Serializer\SerializedName("text")
     * @Serializer\Type("string")
     * @Serializer\Groups({
     *     "comments-list",
     *     "comment-detail",
     * })
     */
    public $text;

    /**
     * @Serializer\SerializedName("created")
     * @Serializer\Type("DateTimeImmutable")
     * @Serializer\Groups({
     *     "comments-list",
     *     "comment-detail",
     * })
     */
    public $created;

    public function __construct(string $id, string $task_Id, string $text, \DateTimeImmutable $created)
    {
        $this->id = $id;
        $this->task_Id = $task_Id;
        $this->text = $text;
        $this->created = $created;
    }
}
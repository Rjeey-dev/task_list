<?php
declare(strict_types=1);

namespace App\Tasks\Domain\DTO;

use JMS\Serializer\Annotation as Serializer;

class Task
{
    /**
     * @Serializer\SerializedName("id")
     * @Serializer\Type("string")
     * @Serializer\Groups({
     *     "tasks-list",
     *     "task-detail",
     * })
     */
    public $id;

    /**
     * @Serializer\SerializedName("todo")
     * @Serializer\Type("string")
     * @Serializer\Groups({
     *     "tasks-list",
     *     "task-detail",
     * })
     */
    public $todo;

    /**
     * @Serializer\SerializedName("doing")
     * @Serializer\Type("string")
     * @Serializer\Groups({
     *     "tasks-list",
     *     "task-detail",
     * })
     */
    public $doing;

    /**
     * @Serializer\SerializedName("done")
     * @Serializer\Type("string")
     * @Serializer\Groups({
     *     "tasks-list",
     *     "task-detail",
     * })
     */
    public $done;

    /**
     * @Serializer\SerializedName("created")
     * @Serializer\Type("DateTimeImmutable")
     * @Serializer\Groups({
     *     "tasks-list",
     *     "task-detail",
     * })
     */
    public $created;

    public function __construct(string $id, string $todo, string $doing, string $done, \DateTimeImmutable $created)
    {
        $this->id = $id;
        $this->todo = $todo;
        $this->doing = $doing;
        $this->done = $done;
        $this->created = $created;
    }
}
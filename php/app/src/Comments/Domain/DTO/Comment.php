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
     *     "users-list",
     *     "user-detail",
     * })
     */
    public $id;

    /**
     * @Serializer\SerializedName("username")
     * @Serializer\Type("string")
     * @Serializer\Groups({
     *     "users-list",
     *     "user-detail",
     * })
     */
    public $userName;

    /**
     * @Serializer\SerializedName("text")
     * @Serializer\Type("string")
     * @Serializer\Groups({
     *     "users-list",
     *     "user-detail",
     * })
     */
    public $text;

    /**
     * @Serializer\SerializedName("created")
     * @Serializer\Type("DateTimeImmutable")
     * @Serializer\Groups({
     *     "users-list",
     *     "user-detail",
     * })
     */
    public $created;

    public function __construct(string $id, string $userName, string $text, \DateTimeImmutable $created)
    {
        $this->id = $id;
        $this->userName = $userName;
        $this->text = $text;
        $this->created = $created;
    }
}
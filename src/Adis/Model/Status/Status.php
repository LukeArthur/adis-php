<?php
declare(strict_types=1);
namespace LukeArthur\Adis\Model\Status;

use LukeArthur\Adis\Model\Model;

/**
 * Status section
 * property: status
 * occurence: 1
 *
 * @author LukeArthur
 */
class Status extends Model
{
    public const CODE_OK = 0;
    public const CODE_OK_ONLY_HUNDRED = 1;
    public const CODE_TECHNICAL_SHUTDOWN = 2;
    public const CODE_SERVICE_UNAVAILABLE = 3;

    /**
     * @var array
     */
    protected static $attributeMap = [
        'odpovedGenerovana' => [
            self::MAP_ATTRIBUTE_NAME => 'responseDate',
            self::MAP_ATTRIBUTE_TYPE => self::TYPE_DATE,
        ],
        'statusCode' => [
            self::MAP_ATTRIBUTE_NAME => 'code',
            self::MAP_ATTRIBUTE_TYPE => self::TYPE_INT,
        ],
        'statusText' => [
            self::MAP_ATTRIBUTE_NAME => 'text',
            self::MAP_ATTRIBUTE_TYPE => self::TYPE_STRING,
        ],
        'bezVypisuUctu' => [
            self::MAP_ATTRIBUTE_NAME => 'noAccountExtract',
            self::MAP_ATTRIBUTE_TYPE => self::TYPE_STRING,
        ],
    ];

    /**
     * @var \DateTime
     */
    protected $responseDate;

    /**
     * @var int
     */
    protected $code;

    /**
     * @var string
     */
    protected $text;

    /**
     * @var string
     */
    protected $noAccountExtract;

    /**
     * @return string|null
     */
    public static function getPropertyName(): ?string
    {
        return 'status';
    }

    /**
     * @return \DateTime
     */
    public function getResponseDate(): \DateTime
    {
        return $this->responseDate;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return string|null
     */
    public function getNoAccountExtract(): ?string
    {
        return $this->noAccountExtract;
    }

    /**
     * @return bool
     */
    public function isResponseOk(): bool
    {
        return static::CODE_OK === $this->getCode();
    }
}

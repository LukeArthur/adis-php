<?php
declare(strict_types=1);
namespace LukeArthur\Adis\Model;

/**
 * Basic model class
 *
 * @author LukeArthur
 */
abstract class Model
{
    public const PATH_SEPARATOR = "/";

    protected const MAP_ATTRIBUTE_NAME = "name";
    protected const MAP_ATTRIBUTE_TYPE = "type";

    protected const TYPE_DATE = "date";
    protected const TYPE_STRING = "string";
    protected const TYPE_INT = "int";

    protected static $attributeMap = [];

    /**
     * @var string
     */
    protected $path;

    /**
     * @param \stdClass $response
     * @param array $path
     */
    public function parse(\stdClass $response, array $path = [])
    {
        $this->path = \implode(static::PATH_SEPARATOR, $path);

        foreach (static::$attributeMap as $key => $data) {
            if (\property_exists($response, $key)) {
                $this->setAttribute(
                    $data[self::MAP_ATTRIBUTE_NAME],
                    $data[self::MAP_ATTRIBUTE_TYPE],
                    $response->{$key}
                );
            }
        }
    }

    /**
     * @param string $attributeName
     * @param string $attributeType
     * @param $value
     */
    protected function setAttribute(string $attributeName, string $attributeType, $value): void
    {
        switch ($attributeType) {
            case static::TYPE_DATE:
                $date = \DateTime::createFromFormat('Y-m-d', $value);
                $this->{$attributeName} = $date;
                break;
            case static::TYPE_INT:
                $this->{$attributeName} = (int) $value;
                break;
            case static::TYPE_STRING:
                $this->{$attributeName} = (string)$value;
                break;
            default:
                $this->{$attributeName} = $value;
        }
    }

    /**
     * @param array $path
     * @param $elements
     * @return array
     */
    protected function addToPath(array $path, ...$elements): array
    {
        $newPath = $path;

        foreach ($elements as $element) {
            \array_push($newPath, $element);
        }

        return $newPath;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string|null
     */
    abstract public static function getPropertyName(): ?string;
}

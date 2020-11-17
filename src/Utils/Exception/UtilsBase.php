<?php

declare(strict_types = 1);

namespace Infinityloop\Utils\Exception;

abstract class UtilsBase extends \Exception implements \JsonSerializable
{
    public const MESSAGE = '';

    protected array $messageArgs = [];
    protected ?array $extensions = null;

    public function __construct(
        ?array $extensions = null
    )
    {
        parent::__construct(\sprintf(static::MESSAGE, ...$this->messageArgs));

        $this->extensions = $extensions;
    }

    public static function notOutputableResponse() : array
    {
        return [
            'message' => 'Server responded with unknown error.',
        ];
    }

    final public function jsonSerialize() : array
    {
        if (!$this->isOutputable()) {
            return self::notOutputableResponse();
        }

        $result = [
            'message' => $this->getMessage(),
        ];

        if (\is_array($this->extensions)) {
            $result['extensions'] = $this->extensions;
        }

        return $result;
    }

    protected function isOutputable() : bool
    {
        return false;
    }
}

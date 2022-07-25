<?php

namespace Thor\Tools\Email;

use ArrayAccess;
use Thor\Tools\Strings;

final class Headers implements ArrayAccess
{

    public const TYPE_OCTET_STREAM = 'application/octet-stream; name="{name}"';
    public const TYPE_MULTIPART = 'multipart/mixed; boundary="{boundary}"';
    public const TYPE_HTML = 'text/html; charset=utf-8';

    private array $headers;

    public function __construct(
        string $contentType = self::TYPE_HTML,
        string $transfertEncoding = '7bit',
        string $contentDisposition = 'inline'
    ) {
        $this->headers = [
            'Content-Type'              => $contentType,
            'Content-Transfer-Encoding' => $transfertEncoding,
            'Content-Disposition'       => $contentDisposition,
        ];
    }

    public static function fileAttachment(string $name): self
    {
        return new self(
            Strings::interpolate(Headers::TYPE_OCTET_STREAM, ['name' => $name]),
            'base64',
            "attachment; filename=\"$name\""
        );
    }

    public function toArray(): array
    {
        return $this->headers;
    }

    public function __toString(): string
    {
        return implode(
            "\r\n",
            array_map(
                fn(string $headerName, string $headerValue) => "$headerName: $headerValue",
                array_keys($this->headers),
                array_values($this->headers)
            )
        );
    }

    public function offsetExists(mixed $offset): bool
    {
        return array_key_exists($offset, $this->headers);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->headers[$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->headers[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        $this->headers[$offset] = null;
        unset($this->headers[$offset]);
    }

}
<?php

namespace Rikudou\LemmyApi\HttpMessage;

use Psr\Http\Message\StreamInterface;
use Rikudou\LemmyApi\Exception\StreamException;

/**
 * @internal
 */
final class StringStream implements StreamInterface
{
    /**
     * @var resource|null
     */
    private $stream;

    private readonly int $size;

    public function __construct(
        string $content
    ) {
        $this->size = strlen($content);
        $stream = fopen('php://temp', 'w+');
        if (!is_resource($stream)) {
            // @codeCoverageIgnoreStart
            throw new StreamException('Cannot create temporary stream for storing data');
            // @codeCoverageIgnoreEnd
        }
        $this->stream = $stream;
        fwrite($this->stream, $content);
        rewind($this->stream);
    }

    public function __toString(): string
    {
        $stream = $this->stream;
        if ($stream === null) {
            return '';
        }
        $content = stream_get_contents($stream, -1, 0);
        if (!is_string($content)) {
            // @codeCoverageIgnoreStart
            $content = '';
            // @codeCoverageIgnoreEnd
        }

        return $content;
    }

    public function close(): void
    {
        if ($this->stream === null) {
            throw new StreamException('The stream is detached');
        }
        $type = get_resource_type($this->stream);
        if ($type !== 'stream') {
            throw new StreamException('The stream is already closed');
        }
        fclose($this->stream);
    }

    public function detach()
    {
        $resource = $this->stream;
        $this->stream = null;

        return $resource;
    }

    public function getSize(): int
    {
        if ($this->stream === null) {
            throw new StreamException('The stream is detached');
        }

        return $this->size;
    }

    public function tell(): int
    {
        if ($this->stream === null) {
            throw new StreamException('The stream is detached');
        }
        $tell = ftell($this->stream);
        if ($tell === false) {
            throw new StreamException('Could not retrieve stream position. Is the stream after EOF?');
        }

        return $tell;
    }

    public function eof(): bool
    {
        if ($this->stream === null) {
            throw new StreamException('The stream is detached');
        }

        return feof($this->stream);
    }

    public function isSeekable(): bool
    {
        if ($this->stream === null) {
            throw new StreamException('The stream is detached');
        }

        return true;
    }

    public function seek($offset, $whence = SEEK_SET): void
    {
        if ($this->stream === null) {
            throw new StreamException('The stream is detached');
        }
        fseek($this->stream, $offset, $whence);
    }

    public function rewind(): void
    {
        if ($this->stream === null) {
            throw new StreamException('The stream is detached');
        }
        rewind($this->stream);
    }

    public function isWritable(): bool
    {
        if ($this->stream === null) {
            throw new StreamException('The stream is detached');
        }

        return true;
    }

    public function write($string): int
    {
        if ($this->stream === null) {
            throw new StreamException('The stream is detached');
        }
        $result = fwrite($this->stream, $string);
        if ($result === false) {
            // @codeCoverageIgnoreStart
            throw new StreamException('Failed to write to the stream');
            // @codeCoverageIgnoreEnd
        }

        return $result;
    }

    public function isReadable(): bool
    {
        if ($this->stream === null) {
            throw new StreamException('The stream is detached');
        }

        return true;
    }

    /**
     * @param int<0, max> $length
     */
    public function read(int $length): string
    {
        if ($this->stream === null) {
            throw new StreamException('The stream is detached');
        }
        $result = fread($this->stream, $length);
        if ($result === false) {
            // @codeCoverageIgnoreStart
            throw new StreamException('Failed to read from stream');
            // @codeCoverageIgnoreEnd
        }

        return $result;
    }

    public function getContents(): string
    {
        if ($this->stream === null) {
            throw new StreamException('The stream is detached');
        }
        $result = stream_get_contents($this->stream);
        if ($result === false) {
            // @codeCoverageIgnoreStart
            throw new StreamException('Failed to read from stream');
            // @codeCoverageIgnoreEnd
        }

        return $result;
    }

    public function getMetadata($key = null): mixed
    {
        if ($this->stream === null) {
            throw new StreamException('The stream is detached');
        }
        $metadata = stream_get_meta_data($this->stream);
        if ($key === null) {
            return $metadata;
        }

        return $metadata[$key] ?? null;
    }
}

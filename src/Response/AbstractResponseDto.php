<?php

namespace Rikudou\LemmyApi\Response;

use BackedEnum;
use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use ReflectionClass;
use ReflectionMethod;
use ReflectionNamedType;
use ReflectionParameter;
use Rikudou\LemmyApi\Attribute\ArrayType;
use Rikudou\LemmyApi\Exception\SerializerException;

abstract readonly class AbstractResponseDto implements ResponseDto
{
    public static function fromRaw(array $raw): static
    {
        $transformedKeys = array_map(
            static fn (string $key): string => (string) preg_replace_callback(
                '@_([a-z])@',
                static fn (array $matches) => strtoupper($matches[1]),
                $key,
            ),
            array_keys($raw),
        );

        $transformed = array_combine($transformedKeys, $raw);

        $constructor = (new ReflectionClass(static::class))->getConstructor();
        if ($constructor === null) {
            return new static(); // @phpstan-ignore-line
        }

        $parameters = self::getParameters($constructor);
        foreach ($transformed as $key => &$value) {
            $parameter = $parameters[$key] ?? null;
            $type = $parameter?->getType() ?? null;
            if ($type === null) {
                continue;
            }
            if (!$type instanceof ReflectionNamedType) {
                continue;
            }

            $typeName = $type->getName();
            if ($type->getName() === 'array' && $arrayType = self::getArrayType($parameters[$key])) {
                assert(is_array($value));
                $value = array_map(
                    static function (array|int|string $raw) use ($arrayType) {
                        if (is_a($arrayType, ResponseDto::class, true)) {
                            assert(is_array($raw));

                            return $arrayType::fromRaw($raw);
                        }

                        if (is_a($arrayType, BackedEnum::class, true)) {
                            assert(is_string($raw) || is_int($raw));

                            return $arrayType::from($raw);
                        }

                        assert(is_array($raw));

                        return new $arrayType(...$raw);
                    },
                    $value,
                );
                continue;
            }

            if (!class_exists($typeName) && !interface_exists($typeName)) {
                continue;
            }

            if (is_a($typeName, BackedEnum::class, true)) {
                assert(is_string($value) || is_int($value));
                $value = $typeName::from($value);
                continue;
            }
            if (is_a($typeName, ResponseDto::class, true)) {
                assert(is_array($value));
                $value = $typeName::fromRaw($value);
                continue;
            }
            if (is_a($typeName, DateTimeInterface::class, true)) {
                assert(is_string($value));
                if ($typeName === DateTimeInterface::class || is_a($typeName, DateTimeImmutable::class, true)) {
                    $value = new DateTimeImmutable($value);
                } else {
                    $value = new DateTime($value);
                }
                continue;
            }

            $value = new $typeName(...$value);
        }

        return new static(...$transformed); // @phpstan-ignore-line
    }

    /**
     * @return array<string, ReflectionParameter>
     */
    private static function getParameters(ReflectionMethod $method): array
    {
        $result = [];
        $parameters = $method->getParameters();
        foreach ($parameters as $parameter) {
            $result[$parameter->getName()] = $parameter;
        }

        return $result;
    }

    /**
     * @return class-string|null
     */
    private static function getArrayType(ReflectionParameter $parameter): ?string
    {
        if (!$parameter->getType() instanceof ReflectionNamedType) {
            throw new SerializerException('Parameter type is not an array');
        }
        if ($parameter->getType()->getName() !== 'array') {
            throw new SerializerException('Parameter type is not an array');
        }

        $attributes = $parameter->getAttributes(ArrayType::class);
        if (!count($attributes)) {
            return null;
        }

        $attribute = $attributes[array_key_first($attributes)]->newInstance();
        assert($attribute instanceof ArrayType);

        return $attribute->type;
    }
}

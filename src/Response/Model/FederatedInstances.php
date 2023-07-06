<?php

namespace Rikudou\LemmyApi\Response\Model;

use Rikudou\LemmyApi\Attribute\ArrayType;
use Rikudou\LemmyApi\Response\AbstractResponseDto;

final readonly class FederatedInstances extends AbstractResponseDto
{
    /**
     * @param array<Instance> $allowed
     * @param array<Instance> $blocked
     * @param array<Instance> $linked
     */
    public function __construct(
        #[ArrayType(Instance::class)]
        public array $allowed,
        #[ArrayType(Instance::class)]
        public array $blocked,
        #[ArrayType(Instance::class)]
        public array $linked,
    ) {
    }
}

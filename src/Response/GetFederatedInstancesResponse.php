<?php

namespace Rikudou\LemmyApi\Response;

use Rikudou\LemmyApi\Response\Model\FederatedInstances;

final readonly class GetFederatedInstancesResponse extends AbstractResponseDto
{
    public function __construct(
        public FederatedInstances $federatedInstances,
    ) {
    }
}

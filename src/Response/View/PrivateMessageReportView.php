<?php

namespace Rikudou\LemmyApi\Response\View;

use Rikudou\LemmyApi\Response\AbstractResponseDto;
use Rikudou\LemmyApi\Response\Model\Person;
use Rikudou\LemmyApi\Response\Model\PrivateMessage;
use Rikudou\LemmyApi\Response\Model\PrivateMessageReport;

final readonly class PrivateMessageReportView extends AbstractResponseDto
{
    public function __construct(
        public Person $creator,
        public PrivateMessage $privateMessage,
        public Person $privateMessageCreator,
        public PrivateMessageReport $privateMessageReport,
        public ?Person $resolver = null,
    ) {
    }
}

<?php

namespace Rikudou\LemmyApi\Response\View;

use Rikudou\LemmyApi\Response\AbstractResponseDto;
use Rikudou\LemmyApi\Response\Model\AdminPurgePost;
use Rikudou\LemmyApi\Response\Model\Community;
use Rikudou\LemmyApi\Response\Model\Person;

final readonly class AdminPurgePostView extends AbstractResponseDto
{
    public function __construct(
        public AdminPurgePost $adminPurgePost,
        public Community $community,
        public ?Person $admin = null,
    ) {
    }
}

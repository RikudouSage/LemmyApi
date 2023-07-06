<?php

namespace Rikudou\LemmyApi\Response;

use Rikudou\LemmyApi\Attribute\ArrayType;
use Rikudou\LemmyApi\Response\View\AdminPurgeCommentView;
use Rikudou\LemmyApi\Response\View\AdminPurgeCommunityView;
use Rikudou\LemmyApi\Response\View\AdminPurgePersonView;
use Rikudou\LemmyApi\Response\View\AdminPurgePostView;
use Rikudou\LemmyApi\Response\View\ModAddCommunityView;
use Rikudou\LemmyApi\Response\View\ModAddView;
use Rikudou\LemmyApi\Response\View\ModBanFromCommunityView;
use Rikudou\LemmyApi\Response\View\ModBanView;
use Rikudou\LemmyApi\Response\View\ModFeaturePostView;
use Rikudou\LemmyApi\Response\View\ModHideCommunityView;
use Rikudou\LemmyApi\Response\View\ModLockPostView;
use Rikudou\LemmyApi\Response\View\ModRemoveCommentView;
use Rikudou\LemmyApi\Response\View\ModRemoveCommunityView;
use Rikudou\LemmyApi\Response\View\ModRemovePostView;
use Rikudou\LemmyApi\Response\View\ModTransferCommunityView;

final readonly class GetModlogResponse extends AbstractResponseDto
{
    /**
     * @param array<ModAddView>               $added
     * @param array<ModAddCommunityView>      $addedToCommunity
     * @param array<AdminPurgeCommentView>    $adminPurgedComments
     * @param array<AdminPurgeCommunityView>  $adminPurgedCommunities
     * @param array<AdminPurgePersonView>     $adminPurgedPersons
     * @param array<AdminPurgePostView>       $adminPurgedPosts
     * @param array<ModBanView>               $banned
     * @param array<ModBanFromCommunityView>  $bannedFromCommunity
     * @param array<ModFeaturePostView>       $featuredPosts
     * @param array<ModHideCommunityView>     $hiddenCommunities
     * @param array<ModLockPostView>          $lockedPosts
     * @param array<ModRemoveCommentView>     $removedComments
     * @param array<ModRemoveCommunityView>   $removedCommunities
     * @param array<ModRemovePostView>        $removedPosts
     * @param array<ModTransferCommunityView> $transferredToCommunity
     */
    public function __construct(
        #[ArrayType(ModAddView::class)]
        public array $added,
        #[ArrayType(ModAddCommunityView::class)]
        public array $addedToCommunity,
        #[ArrayType(AdminPurgeCommentView::class)]
        public array $adminPurgedComments,
        #[ArrayType(AdminPurgeCommunityView::class)]
        public array $adminPurgedCommunities,
        #[ArrayType(AdminPurgePersonView::class)]
        public array $adminPurgedPersons,
        #[ArrayType(AdminPurgePostView::class)]
        public array $adminPurgedPosts,
        #[ArrayType(ModBanView::class)]
        public array $banned,
        #[ArrayType(ModBanFromCommunityView::class)]
        public array $bannedFromCommunity,
        #[ArrayType(ModFeaturePostView::class)]
        public array $featuredPosts,
        #[ArrayType(ModHideCommunityView::class)]
        public array $hiddenCommunities,
        #[ArrayType(ModLockPostView::class)]
        public array $lockedPosts,
        #[ArrayType(ModRemoveCommentView::class)]
        public array $removedComments,
        #[ArrayType(ModRemoveCommunityView::class)]
        public array $removedCommunities,
        #[ArrayType(ModRemovePostView::class)]
        public array $removedPosts,
        #[ArrayType(ModTransferCommunityView::class)]
        public array $transferredToCommunity,
    ) {
    }
}

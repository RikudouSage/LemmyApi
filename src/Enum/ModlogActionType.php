<?php

namespace Rikudou\LemmyApi\Enum;

enum ModlogActionType: string
{
    case All = 'All';
    case ModRemovePost = 'ModRemovePost';
    case ModLockPost = 'ModLockPost';
    case ModFeaturePost = 'ModFeaturePost';
    case ModRemoveComment = 'ModRemoveComment';
    case ModRemoveCommunity = 'ModRemoveCommunity';
    case ModBanFromCommunity = 'ModBanFromCommunity';
    case ModAddCommunity = 'ModAddCommunity';
    case ModTransferCommunity = 'ModTransferCommunity';
    case ModAdd = 'ModAdd';
    case ModBan = 'ModBan';
    case ModHideCommunity = 'ModHideCommunity';
    case AdminPurgePerson = 'AdminPurgePerson';
    case AdminPurgeCommunity = 'AdminPurgeCommunity';
    case AdminPurgePost = 'AdminPurgePost';
    case AdminPurgeComment = 'AdminPurgeComment';
}

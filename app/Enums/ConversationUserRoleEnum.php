<?php

namespace App\Enums;

enum ConversationUserRoleEnum: string
{
    case ADMIN = 'admin';
    case MODERATOR = 'moderator';
    case MEMBER = 'member';
}

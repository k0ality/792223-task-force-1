<?php

namespace Htmlacademy\Actions;

use Htmlacademy\Models\Task;
use Htmlacademy\TaskStatuses;

class Message extends AbstractAction
{
    public static function getSlug(): string
    {
        return 'написать сообщение';
    }

    public static function getName(): string
    {
        return 'message';
    }

    public static function verifyPermission(Task $task, int $userId): bool
    {
        $userRole = $task->getRoleForUser($userId);
        $taskStatus = $task->getStatus();

        if ($userRole !== null &&
            $taskStatus === TaskStatuses::STATUS_ACTIVE) {
            return true;
        }

        return false;
    }
}

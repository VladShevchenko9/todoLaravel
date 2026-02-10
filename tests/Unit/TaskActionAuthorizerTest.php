<?php

namespace Tests\Unit;

use App\Exceptions\UnauthorizedTaskActionException;
use App\Models\Task;
use App\Models\User;
use App\Services\TaskActionAuthorizer;
use PHPUnit\Framework\TestCase;

class TaskActionAuthorizerTest extends TestCase
{
    private TaskActionAuthorizer $authorizer;
    private User $user;
    private Task $task;

    protected function setUp(): void
    {
        parent::setUp();

        $this->authorizer = new TaskActionAuthorizer();
        $this->user = $this->createMock(User::class);
        $this->task = $this->createMock(Task::class);
    }

    public function testAuthorizesActionWithTask(): void
    {
        $this->user
            ->expects($this->once())
            ->method('can')
            ->with('update', $this->task)
            ->willReturn(true);

        $this->authorizer->authorizeAction('update', $this->user, $this->task);
    }

    public function testThrowsExceptionIfActionNotAllowedWithTask(): void
    {
        $this->user
            ->expects($this->once())
            ->method('can')
            ->with('delete', $this->task)
            ->willReturn(false);

        $this->expectException(UnauthorizedTaskActionException::class);

        $this->authorizer->authorizeAction('delete', $this->user, $this->task);
    }

    public function testAuthorizesActionWithoutTask(): void
    {
        $this->user
            ->expects($this->once())
            ->method('can')
            ->with('create', Task::class)
            ->willReturn(true);

        $this->authorizer->authorizeAction('create', $this->user);
    }

    public function testThrowsExceptionIfActionNotAllowedWithoutTask(): void
    {
        $this->user
            ->expects($this->once())
            ->method('can')
            ->with('create', Task::class)
            ->willReturn(false);

        $this->expectException(UnauthorizedTaskActionException::class);

        $this->authorizer->authorizeAction('create', $this->user);
    }
}

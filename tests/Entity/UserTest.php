<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testAddAndGetTask()
    {
        $user = new User();
        $task = new Task();

        $user->addTask($task);

        $this->assertEquals($task, $user->getTasks()[0]);
    }

    public function testAddAndRemoveTask()
    {
        $user = new User();
        $task = new Task();

        $user->addTask($task);
        $user->removeTask($task);

        $this->assertCount(0, $user->getTasks());
    }
}
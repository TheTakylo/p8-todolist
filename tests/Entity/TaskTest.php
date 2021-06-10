<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    public function testSetAndGetCreatedAt()
    {
        $task = new Task();

        $date = new \DateTime();
        $task->setCreatedAt($date);

        $this->assertEquals($date, $task->getCreatedAt());
    }

    public function testSetAndGetIsDone()
    {
        $task = new Task();

        $task->setIsDone(true);

        $this->assertEquals(true, $task->getIsDone());
    }
}
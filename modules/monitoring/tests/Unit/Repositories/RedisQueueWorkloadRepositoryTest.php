<?php

declare(strict_types=1);

use Illuminate\Contracts\Queue\Factory as QueueFactory;
use Laravel\Horizon\Contracts\MasterSupervisorRepository;
use Laravel\Horizon\Contracts\SupervisorRepository;
use Laravel\Horizon\WaitTimeCalculator;
use Modules\Monitoring\Repositories\RedisQueueWorkloadRepository;

beforeEach(function (): void {

    $this->queue       = mock(QueueFactory::class);
    $this->waitTime    = mock(WaitTimeCalculator::class);
    $this->supervisors = mock(SupervisorRepository::class);
    $this->masters     = mock(MasterSupervisorRepository::class);

    $this->sut = new RedisQueueWorkloadRepository(
        $this->queue,
        $this->waitTime,
        $this->masters,
        $this->supervisors
    );
});

it('returns empty array when no supervisors exist', function (): void {
    $this->supervisors->shouldReceive('all')->andReturn([]);
    $this->waitTime->shouldReceive('calculate')->andReturn([]);

    expect($this->sut->get())
        ->toBeEmpty();
});

it('correctly processes single queue supervisors', function (): void {

    $this->supervisors->shouldReceive('all')->andReturn([
        ['processes' => ['redis:default' => 3]],
        ['processes' => ['redis:high' => 2]],
    ]);

    $this->waitTime->shouldReceive('calculate')->andReturn([
        'redis:default' => 5,
        'redis:high'    => 8,
    ]);

    $this->queue->shouldReceive('connection->readyNow')
        ->with('default')->andReturn(10);
    $this->queue->shouldReceive('connection->readyNow')
        ->with('high')->andReturn(15);

    $result = $this->sut->get();

    expect($result)->toBe([
        [
            'name'      => 'default',
            'length'    => 10,
            'wait'      => 5,
            'processes' => 3,
        ],
        [
            'name'      => 'high',
            'length'    => 15,
            'wait'      => 8,
            'processes' => 2,
        ],
    ]);
});

it('correctly processes combined queue supervisors', function (): void {

    $this->supervisors->shouldReceive('all')->andReturn([
        ['processes' => ['redis:high,default' => 4]],
    ]);

    $this->waitTime->shouldReceive('calculate')->andReturn([
        'redis:high,default' => 10,
    ]);

    $this->waitTime->shouldReceive('calculateTimeToClear')
        ->with('redis', 'high', 4)
        ->andReturn(12);
    $this->waitTime->shouldReceive('calculateTimeToClear')
        ->with('redis', 'default', 4)
        ->andReturn(8);

    $this->queue->shouldReceive('connection->readyNow')
        ->with('high')->andReturn(15);
    $this->queue->shouldReceive('connection->readyNow')
        ->with('default')->andReturn(10);

    $result = $this->sut->get();

    expect($result)->toBe([
        1 => [
            'name'      => 'default',
            'length'    => 10,
            'wait'      => 0,
            'processes' => 4,
        ],
        0 => [
            'name'      => 'high',
            'length'    => 15,
            'wait'      => 0,
            'processes' => 4,
        ],
    ]);
});

it('combines metrics for same queue across multiple supervisors', function (): void {

    $this->supervisors->shouldReceive('all')->andReturn([
        ['processes' => ['redis:default' => 3]],
        ['processes' => ['redis:high,default' => 2]],
    ]);

    $this->waitTime->shouldReceive('calculate')->andReturn([
        'redis:default'      => 5,
        'redis:high,default' => 8,
    ]);

    $this->waitTime->shouldReceive('calculateTimeToClear')
        ->with('redis', 'default', 2)
        ->andReturn(6);
    $this->waitTime->shouldReceive('calculateTimeToClear')
        ->with('redis', 'high', 2)
        ->andReturn(10);

    $this->queue->shouldReceive('connection->readyNow')
        ->with('default')->andReturn(10);
    $this->queue->shouldReceive('connection->readyNow')
        ->with('high')->andReturn(15);

    $result = $this->sut->get();

    expect($result)->toBe([
        [
            'name'      => 'default',
            'length'    => 10, // 10 from single queue + 10 from combined
            'wait'      => 5,    // Max of 5 (from single) and 6 (from combined)
            'processes' => 5, // 3 + 2
        ],
        [
            'name'      => 'high',
            'length'    => 15,
            'wait'      => 0,
            'processes' => 2,
        ],
    ]);
});

it('correctly calculates wait time for split queues', function (): void {

    $this->supervisors->shouldReceive('all')->andReturn([
        ['processes' => ['redis:high,default' => 4]],
    ]);

    $this->waitTime->shouldReceive('calculate')
        ->andReturn(['redis:high,default' => 10]);

    $this->waitTime->shouldReceive('calculateTimeToClear')
        ->with('redis', 'high', 4)
        ->andReturn(12);
    $this->waitTime->shouldReceive('calculateTimeToClear')
        ->with('redis', 'default', 4)
        ->andReturn(8);

    $this->queue->shouldReceive('connection->readyNow')
        ->with('high')->andReturn(15);
    $this->queue->shouldReceive('connection->readyNow')
        ->with('default')->andReturn(10);

    $result = $this->sut->get();

    expect($result)->toBe([
        1 => [
            'name'      => 'default',
            'length'    => 10,
            'wait'      => 0,
            'processes' => 4,
        ],
        0 => [
            'name'      => 'high',
            'length'    => 15,
            'wait'      => 0,
            'processes' => 4,
        ],
    ]);
});

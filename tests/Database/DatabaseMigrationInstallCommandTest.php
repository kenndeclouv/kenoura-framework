<?php

namespace Illuminate\Tests\Database;

use Illuminate\Database\Console\Migrations\InstallCommand;
use Illuminate\Database\Migrations\MigrationRepositoryInterface;
use Illuminate\Foundation\Application;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

class DatabaseMigrationInstallCommandTest extends TestCase
{
    protected function tearDown(): void
    {
        m::close();
    }

    public function testFireCallsRepositoryToInstall()
    {
        $command = new InstallCommand($repo = m::mock(MigrationRepositoryInterface::class));
        $command->setKenoura(new Application);
        $repo->shouldReceive('setSource')->once()->with('foo');
        $repo->shouldReceive('createRepository')->once();

        $this->runCommand($command, ['--database' => 'foo']);
    }

    protected function runCommand($command, $options = [])
    {
        return $command->run(new ArrayInput($options), new NullOutput);
    }
}

<?php 

require_once __DIR__.'/bootstrap.php.cache';
require_once __DIR__.'/AppKernel.php';

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Input\ArrayInput;
use Doctrine\Bundle\DoctrineBundle\Command\CreateDatabaseDoctrineCommand;
use Doctrine\Bundle\DoctrineBundle\Command\DropDatabaseDoctrineCommand;
use Doctrine\Bundle\DoctrineBundle\Command\Proxy\CreateSchemaDoctrineCommand;
use FOS\UserBundle\Command\CreateUserCommand;

$kernel = new AppKernel('test', true);
$kernel->boot();

$application = new Application($kernel);
$connection = $application->getKernel()->getContainer()->get('doctrine')->getConnection();
$output = new ConsoleOutput();

$command = new DropDatabaseDoctrineCommand();
$application->add($command);
$input = new ArrayInput(array(
    'command' => 'doctrine:database:drop',
    '--force' => true,
));
$command->run($input, $output);

if ($connection->isConnected()) {
    $connection->close();
}

$command = new CreateDatabaseDoctrineCommand();
$application->add($command);
$input = new ArrayInput(array(
    'command' => 'doctrine:database:create',
));
$command->run($input, $output);

if ($connection->isConnected()) {
    $connection->close();
}

$command = new CreateSchemaDoctrineCommand();
$application->add($command);
$input = new ArrayInput(array(
    'command' => 'doctrine:schema:create',
));
$command->run($input, $output);

if ($connection->isConnected()) {
    $connection->close();
}

$command = new CreateUserCommand();
$application->add($command);
$input = new ArrayInput(array(
    'command' => 'fos:user:create',
    'username' => 'testSuperAdmin',
    'email' => 'test.super.admin@test-sl.com',
    'password' => '<testSuperAdmin>',
    '--super-admin' => true,
));
$command->run($input, $output);

if ($connection->isConnected()) {
    $connection->close();
}

$command = new CreateUserCommand();
$application->add($command);
$input = new ArrayInput(array(
    'command' => 'fos:user:create',
    'username' => 'testUser',
    'email' => 'test.admin@test-sl.com',
    'password' => '<testUser>',
));
$command->run($input, $output);

if ($connection->isConnected()) {
    $connection->close();
}

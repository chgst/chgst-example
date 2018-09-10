<?php

use Changeset\Command\Command;
use Changeset\Command\Handler;
use Changeset\Communication\InMemoryCommandBus;
use Changeset\Communication\InMemoryEventBus;
use Changeset\Event\ObjectRepository;
use Symfony\Component\EventDispatcher\EventDispatcher;

require_once 'bootstrap.php';

$repository = new ObjectRepository($entityManager, DefaultEvent::class);
$dispatcher = new EventDispatcher();

$handler = new Handler($dispatcher, $repository);

$eventBus = new InMemoryEventBus();

$commandBus = new InMemoryCommandBus();
$commandBus->setHandler($handler);
$commandBus->setEventBus($eventBus);

$consoleOut = new ConsoleOutListener();

$eventBus->addListener($consoleOut);
$eventBus->enableListeners();

$buildingEnterProjector = new BuildingEnterProjector($entityManager);
$eventBus->addProjector($buildingEnterProjector);

$commandBus->dispatch(new Command('enter_building', 'Building', 'main', json_encode(['user' => 'emma'])));



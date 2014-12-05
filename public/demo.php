<!DOCTYPE HTML>
<html>
	<?php include "partials/head.php"; ?>

    <body class="no-sidebar">

    <?php include "partials/header.php"; ?>


    <?php include "partials/footer.php"; ?>

	</body>
</html>



<?php


require dirname(__DIR__) . '/vendor/autoload.php';
require __DIR__ . '/../tests/demo/DataCollector/User.php';
require __DIR__ . '/../tests/demo/DataCollector/Request.php';

$profiler = new \Fabfuel\Prophiler\Profiler();
$logger = new \Fabfuel\Prophiler\Adapter\Psr\Log\Logger($profiler);

$multiplicator = 20;
$wait = function ($time) use ($multiplicator) {
    return $time * rand($multiplicator * .8, $multiplicator*1.2);
};

$bootstrap = $profiler->start('Bootstrap', ['lorem' => 'ipsum'], 'Application');
usleep($wait(50));
$profiler->stop($bootstrap);

$logger->info('Bootstrap has finished', ['some' => 'context']);

$bootstrap = $profiler->start('Session::load', ['lorem' => 'ipsum'], 'Sessions');
usleep($wait(45));
$profiler->stop($bootstrap);

$dispatcher = $profiler->start('Dispatcher', ['abc' => '123', 'foobar' => true], 'Dispatcher');
usleep($wait(25));

    $logger->warning('Not everything ready to go', ['some' => 'context']);

    $router = $profiler->start('Router', ['some' => 'value', 'foobar' => 123], 'Dispatcher');
    usleep($wait(150));

    $profiler->stop($router);

    $logger->alert('Route could not be found');

    $controller = $profiler->start('Controller', ['some' => 'value', 'foobar' => 123, 'array' => ['foo' => 'bar', 'lorem' => true, 'ipsum' => 1.5]], 'Application');
    usleep($wait(200));

        $view = $profiler->start('View::render', ['data' => ['user' => ['name' => 'John Doe', 'age' => 26]], 'foobar' => 123], 'View');
        usleep($wait(10));
        $profiler->stop($view);

        $logger->notice('Undefined variable: $foobar', ['some' => 'context']);

        $view = $profiler->start('View::render', ['data' => ['user' => ['name' => 'John Doe', 'age' => 26]], 'foobar' => 123], 'View');
        usleep($wait(10));
        $profiler->stop($view);

        $logger->critical('Lorem Ipsum', ['some' => 'context']);

        $database = $profiler->start('\Fabfuel\Mongo\Collection\Foobar\LoremIpsum::doSomeFancyFoobarStuff', ['query' => ['user' => 12312], 'foobar' => 123], 'MongoDB');
        usleep($wait(200));
        $profiler->stop($database);

        $logger->debug('Analyze query', ['query' => ['user' => 12312], 'foobar' => 123]);

        $view = $profiler->start('View::render', ['data' => ['user' => ['name' => 'John Doe', 'age' => 26]], 'foobar' => 123], 'View');
        usleep($wait(100));
        $profiler->stop($view);

    $profiler->stop($controller);
    usleep($wait(20));

    $logger->error('Foobar not found', ['some' => 'context']);

$profiler->stop($dispatcher);

$bootstrap = $profiler->start('Session::write', ['lorem' => 'ipsum'], 'Sessions');
usleep($wait(45));
$profiler->stop($bootstrap);
$logger->emergency('Done, gimme work!');

$toolbar = new \Fabfuel\Prophiler\Toolbar($profiler);
$toolbar->addDataCollector(new \Fabfuel\Prophiler\Demo\DataCollector\Request);
$toolbar->addDataCollector(new \Fabfuel\Prophiler\Demo\DataCollector\User);
echo $toolbar->render();

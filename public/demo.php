<!DOCTYPE HTML>
<html>
	<?php include "partials/head.php"; ?>

    <link rel="stylesheet" href="/css/animate.css" />

    <body class="no-sidebar">

    <!-- Header -->
    <div id="header-wrapper">
        <div id="header" class="container">
            <?php require 'partials/navigation.php'; ?>
        </div>
    </div>

    <!-- Main -->
    <div class="wrapper">
        <div class="container" id="main">

            <!-- Content -->
                <article id="content">
                    <header>
                        <h2>Try a Demo</h2>
                    </header>
                    <p>
                        The server worked hard to build this page...<br>
                        Okay, that's fake.<br>
                        But hey, this is just a demo.<br>
                        To see the Prophiler in action, just click one of the buttons above.<br>
                        And now some placeholder text.
                    </p>
                    <p>Lorem ipsum usu amet dicat nullam ea. Nec detracto lucilius democritum in, ne usu delenit offendit deterruisset. Recusabo iracundia molestiae ea pro, suas dicta nemore an cum, erat dolorum nonummy mel ea. Iisque labores liberavisse in mei, dico laoreet elaboraret nam et, iudico verterem platonem est an. Te usu paulo vidisse epicuri, facilis mentitum liberavisse vel ut, movet iriure invidunt ut quo. Ad melius mnesarchum scribentur eum, mel at mundi impetus utroque.</p>
                    <p>Viris imperdiet forensibus ius ei, ea mel modus fabellas complectitur, has decore repudiare ne. Mea graeci vivendo id, legere sententiae reprehendunt an pro. In dico quot scripta nec, pri ut ullum virtute dissentias, mel tritani officiis digniferumque at. Ad pri appareat tincidunt forensibus, cu vis omnium maluisset, nam ea dicat detraxit suavitate. Ius ei sumo aliquam takimata, mei odio graece voluptatum no, ad vel meis graecis corpora.</p>
                    <p>Ad mel causae virtute prodesset, aperiam percipitur in mei. An homero meliore dolorem usu, choro tempor democritum te mea, ei mucius aliquip accusam pri. In malorum dolorem recteque ius, ne vix graeco similique moderatius. Esse probo dicat quo eu, mei forensibus constituto philosophia ne, ea eum quot harum paulo. Ius elit aeque te, saperet luptatum elaboraret an quo, sonet audiam consectetuer at pro.</p>

                </article>

        </div>
    </div>

    <div id="demo-arrow">
        <i class="fa fa-arrow-up animated infinite bounce"></i>
    </div>

    <?php include "partials/footer.php"; ?>

	</body>
</html><?php


require dirname(__DIR__) . '/vendor/autoload.php';
require __DIR__ . '/DataCollector/User.php';
require __DIR__ . '/DataCollector/Request.php';

$profiler = new \Fabfuel\Prophiler\Profiler();
$profiler->addAggregator(new \Fabfuel\Prophiler\Aggregator\Database\QueryAggregator());
$profiler->addAggregator(new \Fabfuel\Prophiler\Aggregator\Cache\CacheAggregator());

$logger = new \Fabfuel\Prophiler\Adapter\Psr\Log\Logger($profiler);

$multiplicator = 10;
$wait = function ($time) use ($multiplicator) {
    return $time * rand($multiplicator * .8, $multiplicator*1.2);
};

$bootstrap = $profiler->start('Bootstrap', ['lorem' => 'ipsum'], 'Application');
usleep($wait(50));
$profiler->stop($bootstrap);

$logger->info('Bootstrap has finished', ['some' => 'context']);

$sessionLoad = $profiler->start('Session::load', ['lorem' => ''], 'Sessions');
usleep($wait(45));
$profiler->stop($sessionLoad);

$dispatcher = $profiler->start('Dispatcher', ['abc' => '123', 'foobar' => true], 'Dispatcher');
usleep($wait(25));

    $logger->warning('Not everything ready to go', ['some' => 'context']);

    $router = $profiler->start('Router', ['some' => 'value', 'foobar' => 123], 'Dispatcher');
    usleep($wait(150));

    $profiler->stop($router);

    $logger->alert('Route not found', ['lorem' => 'ipsum', 'foobar' => true]);

    $controller = $profiler->start('Controller', ['some' => 'value', 'foobar' => 123, 'array' => ['foo' => 'bar', 'lorem' => true, 'ipsum' => 1.5]], 'Application');
    usleep($wait(200));

        $cache = $profiler->start('Phalcon\Cache\Backend\Apc::get', ['get' => 'app_data__lorem_ipsum'], 'Cache');
        usleep($wait(20));
        $profiler->stop($cache);

        $view = $profiler->start('PDO::exec', ['query' => 'DELETE FROM users WHERE email = "foo@bar.com"'], 'Database');
        usleep($wait(100));
        $profiler->stop($view);

        $cache = $profiler->start('Phalcon\Cache\Backend\Apc::exists', ['get' => 'app_data__lorem_ipsum'], 'Cache');
        usleep($wait(20));
        $profiler->stop($cache);

        $cache = $profiler->start('Phalcon\Cache\Backend\Apc::get', ['get' => 'app_data__lorem_ipsum'], 'Cache');
        usleep($wait(20));
        $profiler->stop($cache);

        for ($i=0; $i <= 3; $i++) {
            $view = $profiler->start('PDO::query', ['query' => 'SELECT article.*, author.name FROM article JOIN author ON article.author_id = author.id WHERE article.id = ?;'], 'Database');
            usleep($wait(150));
            $profiler->stop($view);
        }


        $cache = $profiler->start('Phalcon\Cache\Backend\Apc::exists', ['get' => 'app_data__lorem_ipsum'], 'Cache');
        usleep($wait(20));
        $profiler->stop($cache);

        $cache = $profiler->start('Phalcon\Cache\Backend\Apc::get', ['get' => 'app_data__lorem_ipsum'], 'Cache');
        usleep($wait(20));
        $profiler->stop($cache);

        for ($i=0; $i <= 8; $i++) {
            $query = $profiler->start('PDO::query', ['query' => 'SELECT lorem, ipsum FROM foobar WHERE id = ? LIMIT 1;'], 'Database');
            usleep($wait(rand(70, 100)));
            $profiler->stop($query);
        }


        $view = $profiler->start('View::render', ['data' => ['user' => ['name' => 'John Doe', 'age' => 26]], 'foobar' => 123], 'View');
        usleep($wait(10));
        $profiler->stop($view);

        $logger->notice('Undefined variable: $foobar', ['some' => 'context']);

        $database = $profiler->start('\Fabfuel\Mongo\Collection\Foobar::find', ['query' => ['user' => '54815c5081de416a770041a7', 'active' => true], 'foobar' => 123], 'MongoDB');
        usleep($wait(25));
        $profiler->stop($database);

        $logger->debug('Analyze query', ['query' => ['user' => 12312], 'foobar' => 123]);

        $view = $profiler->start('View::render', ['data' => ['user' => ['name' => 'John Doe', 'age' => 26]], 'foobar' => 123], 'View');
        usleep($wait(10));
        $profiler->stop($view);

        $logger->critical('Lorem Ipsum', ['some' => 'context']);

        $view = $profiler->start('View::render', ['data' => ['user' => ['name' => 'John Doe', 'age' => 26]], 'foobar' => 123], 'View');
        usleep($wait(100));
        $profiler->stop($view);

    $profiler->stop($controller);
    usleep($wait(20));

    $logger->error('Foobar not found', ['some' => 'context']);

$profiler->stop($dispatcher);

$sessionWrite = $profiler->start('Session::write', ['lorem' => 'ipsum'], 'Sessions');
usleep($wait(45));
$profiler->stop($sessionWrite);
$logger->emergency('Done, gimme work!');

$toolbar = new \Fabfuel\Prophiler\Toolbar($profiler);
$toolbar->addDataCollector(new \Fabfuel\Prophiler\Demo\DataCollector\Request);
$toolbar->addDataCollector(new \Fabfuel\Prophiler\Demo\DataCollector\User);
echo $toolbar->render();


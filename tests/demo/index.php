<html>
<head>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
<!--    <script src="//code.jquery.com/jquery-2.1.1.min.js"></script>-->
<!--    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>-->

    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            font-size: 12px;
            line-height: 1.42857143;
        }
        article {
            padding-top: 30px;
            margin: 30px;
        }
    </style>
</head>
<body>
<a href="https://github.com/fabfuel/prophiler"><img style="z-index: 100000; position: fixed; top: 0; right: 0; border: 0;" src="https://camo.githubusercontent.com/38ef81f8aca64bb9a64448d0d70f1308ef5341ab/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f6461726b626c75655f3132313632312e706e67" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_darkblue_121621.png"></a>
<article>
    <p>Lorem ipsum usu amet dicat nullam ea. Nec detracto lucilius democritum in, ne usu delenit offendit deterruisset. Recusabo iracundia molestiae ea pro, suas dicta nemore an cum, erat dolorum nonummy mel ea. Iisque labores liberavisse in mei, dico laoreet elaboraret nam et, iudico verterem platonem est an. Te usu paulo vidisse epicuri, facilis mentitum liberavisse vel ut, movet iriure invidunt ut quo. Ad melius mnesarchum scribentur eum, mel at mundi impetus utroque.</p>
    <p>Viris imperdiet forensibus ius ei, ea mel modus fabellas complectitur, has decore repudiare ne. Mea graeci vivendo id, legere sententiae reprehendunt an pro. In dico quot scripta nec, pri ut ullum virtute dissentias, mel tritani officiis digniferumque at. Ad pri appareat tincidunt forensibus, cu vis omnium maluisset, nam ea dicat detraxit suavitate. Ius ei sumo aliquam takimata, mei odio graece voluptatum no, ad vel meis graecis corpora.</p>
    <p>Ad mel causae virtute prodesset, aperiam percipitur in mei. An homero meliore dolorem usu, choro tempor democritum te mea, ei mucius aliquip accusam pri. In malorum dolorem recteque ius, ne vix graeco similique moderatius. Esse probo dicat quo eu, mei forensibus constituto philosophia ne, ea eum quot harum paulo. Ius elit aeque te, saperet luptatum elaboraret an quo, sonet audiam consectetuer at pro.</p>
    <p>Ius tempor qualisque suscipiantur ne. Vim quot habemus consectetuer id, ad ornatus labores liberavisse eum. Mel tantas melius adversarium et, pri ne augue imperdiet assentior. In usu dicam albucius offendit, et inani mucius aliquando sea, ancillae platonem est an. Cu vis option maiestatis, pri et habeo soluta comprehensam, has soluta dicunt liberavisse at.</p>
    <p>Lorem ipsum usu amet dicat nullam ea. Nec detracto lucilius democritum in, ne usu delenit offendit deterruisset. Recusabo iracundia molestiae ea pro, suas dicta nemore an cum, erat dolorum nonummy mel ea. Iisque labores liberavisse in mei, dico laoreet elaboraret nam et, iudico verterem platonem est an. Te usu paulo vidisse epicuri, facilis mentitum liberavisse vel ut, movet iriure invidunt ut quo. Ad melius mnesarchum scribentur eum, mel at mundi impetus utroque.</p>
    <p>Viris imperdiet forensibus ius ei, ea mel modus fabellas complectitur, has decore repudiare ne. Mea graeci vivendo id, legere sententiae reprehendunt an pro. In dico quot scripta nec, pri ut ullum virtute dissentias, mel tritani officiis digniferumque at. Ad pri appareat tincidunt forensibus, cu vis omnium maluisset, nam ea dicat detraxit suavitate. Ius ei sumo aliquam takimata, mei odio graece voluptatum no, ad vel meis graecis corpora.</p>
    <p>Ad mel causae virtute prodesset, aperiam percipitur in mei. An homero meliore dolorem usu, choro tempor democritum te mea, ei mucius aliquip accusam pri. In malorum dolorem recteque ius, ne vix graeco similique moderatius. Esse probo dicat quo eu, mei forensibus constituto philosophia ne, ea eum quot harum paulo. Ius elit aeque te, saperet luptatum elaboraret an quo, sonet audiam consectetuer at pro.</p>
    <p>Ius tempor qualisque suscipiantur ne. Vim quot habemus consectetuer id, ad ornatus labores liberavisse eum. Mel tantas melius adversarium et, pri ne augue imperdiet assentior. In usu dicam albucius offendit, et inani mucius aliquando sea, ancillae platonem est an. Cu vis option maiestatis, pri et habeo soluta comprehensam, has soluta dicunt liberavisse at.</p>
</article>


<div style="text-align: center;">
    <a href="https://scrutinizer-ci.com/g/fabfuel/prophiler/?branch=develop"><img
        src="https://scrutinizer-ci.com/g/fabfuel/prophiler/badges/quality-score.png?b=develop"
        alt="Scrutinizer Code Quality"
        data-canonical-src="https://scrutinizer-ci.com/g/fabfuel/prophiler/badges/quality-score.png?b=develop"
        style="max-width:100%;"></a>
    <a href="https://scrutinizer-ci.com/g/fabfuel/prophiler/?branch=develop"><img
        src="https://scrutinizer-ci.com/g/fabfuel/prophiler/badges/coverage.png?b=develop"
        alt="Code Coverage"
        data-canonical-src="https://scrutinizer-ci.com/g/fabfuel/prophiler/badges/coverage.png?b=develop"
        style="max-width:100%;"></a>
    <a href="https://scrutinizer-ci.com/g/fabfuel/prophiler/build-status/develop"><img
        src="https://scrutinizer-ci.com/g/fabfuel/prophiler/badges/build.png?b=develop"
        alt="Build Status"
        data-canonical-src="https://scrutinizer-ci.com/g/fabfuel/prophiler/badges/build.png?b=develop"
        style="max-width:100%;"></a>
</div>

</body>
</html>

<?php

require dirname(dirname(__DIR__)) . '/vendor/autoload.php';
require __DIR__ . '/DataCollector/User.php';
require __DIR__ . '/DataCollector/Request.php';

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


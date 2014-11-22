<html>
<head>
<!--    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">-->
<!--    <script src="//code.jquery.com/jquery-2.1.1.min.js"></script>-->
<!--    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>-->
</head>
<body>
    <p>Lorem ipsum usu amet dicat nullam ea. Nec detracto lucilius democritum in, ne usu delenit offendit deterruisset. Recusabo iracundia molestiae ea pro, suas dicta nemore an cum, erat dolorum nonummy mel ea. Iisque labores liberavisse in mei, dico laoreet elaboraret nam et, iudico verterem platonem est an. Te usu paulo vidisse epicuri, facilis mentitum liberavisse vel ut, movet iriure invidunt ut quo. Ad melius mnesarchum scribentur eum, mel at mundi impetus utroque.</p>
    <p>Viris imperdiet forensibus ius ei, ea mel modus fabellas complectitur, has decore repudiare ne. Mea graeci vivendo id, legere sententiae reprehendunt an pro. In dico quot scripta nec, pri ut ullum virtute dissentias, mel tritani officiis digniferumque at. Ad pri appareat tincidunt forensibus, cu vis omnium maluisset, nam ea dicat detraxit suavitate. Ius ei sumo aliquam takimata, mei odio graece voluptatum no, ad vel meis graecis corpora.</p>
    <p>Ad mel causae virtute prodesset, aperiam percipitur in mei. An homero meliore dolorem usu, choro tempor democritum te mea, ei mucius aliquip accusam pri. In malorum dolorem recteque ius, ne vix graeco similique moderatius. Esse probo dicat quo eu, mei forensibus constituto philosophia ne, ea eum quot harum paulo. Ius elit aeque te, saperet luptatum elaboraret an quo, sonet audiam consectetuer at pro.</p>
    <p>Ius tempor qualisque suscipiantur ne. Vim quot habemus consectetuer id, ad ornatus labores liberavisse eum. Mel tantas melius adversarium et, pri ne augue imperdiet assentior. In usu dicam albucius offendit, et inani mucius aliquando sea, ancillae platonem est an. Cu vis option maiestatis, pri et habeo soluta comprehensam, has soluta dicunt liberavisse at.</p>
    <p>Lorem ipsum usu amet dicat nullam ea. Nec detracto lucilius democritum in, ne usu delenit offendit deterruisset. Recusabo iracundia molestiae ea pro, suas dicta nemore an cum, erat dolorum nonummy mel ea. Iisque labores liberavisse in mei, dico laoreet elaboraret nam et, iudico verterem platonem est an. Te usu paulo vidisse epicuri, facilis mentitum liberavisse vel ut, movet iriure invidunt ut quo. Ad melius mnesarchum scribentur eum, mel at mundi impetus utroque.</p>
    <p>Viris imperdiet forensibus ius ei, ea mel modus fabellas complectitur, has decore repudiare ne. Mea graeci vivendo id, legere sententiae reprehendunt an pro. In dico quot scripta nec, pri ut ullum virtute dissentias, mel tritani officiis digniferumque at. Ad pri appareat tincidunt forensibus, cu vis omnium maluisset, nam ea dicat detraxit suavitate. Ius ei sumo aliquam takimata, mei odio graece voluptatum no, ad vel meis graecis corpora.</p>
    <p>Ad mel causae virtute prodesset, aperiam percipitur in mei. An homero meliore dolorem usu, choro tempor democritum te mea, ei mucius aliquip accusam pri. In malorum dolorem recteque ius, ne vix graeco similique moderatius. Esse probo dicat quo eu, mei forensibus constituto philosophia ne, ea eum quot harum paulo. Ius elit aeque te, saperet luptatum elaboraret an quo, sonet audiam consectetuer at pro.</p>
    <p>Ius tempor qualisque suscipiantur ne. Vim quot habemus consectetuer id, ad ornatus labores liberavisse eum. Mel tantas melius adversarium et, pri ne augue imperdiet assentior. In usu dicam albucius offendit, et inani mucius aliquando sea, ancillae platonem est an. Cu vis option maiestatis, pri et habeo soluta comprehensam, has soluta dicunt liberavisse at.</p>
</body>
</html>

<?php

require dirname(dirname(__DIR__)) . '/vendor/autoload.php';

$profiler = new \Fabfuel\Prophiler\Profiler();

$multiplicator = 100;
$wait = function ($time) use ($multiplicator) {
    return $time * rand($multiplicator * .8, $multiplicator*1.2);
};

$bootstrap = $profiler->start('Bootstrap', ['lorem' => 'ipsum'], 'Application');
usleep($wait(50));
$profiler->stop($bootstrap);

$bootstrap = $profiler->start('Session::load', ['lorem' => 'ipsum'], 'Sessions');
usleep($wait(45));
$profiler->stop($bootstrap);

$dispatcher = $profiler->start('Dispatcher', ['abc' => '123', 'foobar' => true], 'Dispatcher');
usleep($wait(25));

    $router = $profiler->start('Router', ['some' => 'value', 'foobar' => 123], 'Dispatcher');
    usleep($wait(150));

    $profiler->stop($router);

    $controller = $profiler->start('Controller', ['some' => 'value', 'foobar' => 123], 'Application');
    usleep($wait(200));

        $view = $profiler->start('View::render', ['data' => ['user' => ['name' => 'John Doe', 'age' => 26]], 'foobar' => 123], 'View');
        usleep($wait(10));
        $profiler->stop($view);

        $view = $profiler->start('View::render', ['data' => ['user' => ['name' => 'John Doe', 'age' => 26]], 'foobar' => 123], 'View');
        usleep($wait(10));
        $profiler->stop($view);

        $database = $profiler->start('\Fabfuel\Mongo\Collection\Foobar\LoremIpsum::doSomeFancyFoobarStuff', ['query' => ['user' => 12312], 'foobar' => 123], 'MongoDB Super Database');
        usleep($wait(200));
        $profiler->stop($database);

        $view = $profiler->start('View::render', ['data' => ['user' => ['name' => 'John Doe', 'age' => 26]], 'foobar' => 123], 'View');
        usleep($wait(100));
        $profiler->stop($view);

    $profiler->stop($controller);
    usleep($wait(20));

$profiler->stop($dispatcher);

$bootstrap = $profiler->start('Session::write', ['lorem' => 'ipsum'], 'Sessions');
usleep($wait(45));
$profiler->stop($bootstrap);


$toolbar = new \Fabfuel\Prophiler\Toolbar($profiler);
echo $toolbar->render();

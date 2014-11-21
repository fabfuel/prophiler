<html>
<head>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet"></head>
    <script src="//code.jquery.com/jquery-2.1.1.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
</html>

<?php

require dirname(dirname(__DIR__)) . '/vendor/autoload.php';

$profiler = new \Fabfuel\Prophiler\Profiler();

$test1 = $profiler->start('Test #1', ['lorem' => 'ipsum'], 'Test');
usleep(500);
$profiler->stop($test1);

usleep(500);
$test2 = $profiler->start('Test #2', ['abc' => '123', 'foobar' => true], 'Test');

usleep(100);
$test3 = $profiler->start('Test #3', ['some' => 'value', 'foobar' => 123], 'Test');

usleep(750);
$profiler->stop($test3);

usleep(250);
$profiler->stop($test2);


$toolbar = new \Fabfuel\Prophiler\Toolbar($profiler);
echo $toolbar->render();

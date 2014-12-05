#Prophiler - A Phalcon Profiler & Dev Toolbar

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/fabfuel/prophiler/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/fabfuel/prophiler/?branch=develop)
[![Code Coverage](https://scrutinizer-ci.com/g/fabfuel/prophiler/badges/coverage.png?b=develop)](https://scrutinizer-ci.com/g/fabfuel/prophiler/?branch=develop)
[![Build Status](https://scrutinizer-ci.com/g/fabfuel/prophiler/badges/build.png?b=develop)](https://scrutinizer-ci.com/g/fabfuel/prophiler/build-status/develop)


## Demo
Here you can see the toolbar in action:
http://prophiler.fabfuel.de/

[![Timeline Preview](http://prophiler.fabfuel.de/img/timeline.png)](http://prophiler.fabfuel.de/)


## Installation
You can use composer to install the Prophiler. Just add it as dependency:

    "require": {
       	"fabfuel/prophiler": "~1.0",
    }

## Setup
Setting up the Prophiler and the developer toolbar can be done by these simple steps. It could all be done in your front controller (e.g. public/index.php) 

#####1. Initialize the Profiler (as soon as possible)
Generally it makes sense to initialize the profiler as soon as possible, to measure as much execution time as you can. You should initialize the profiler in your frontcontroller or a separat bootstrap file right after requiring the Composer autoloader.

```php
$profiler = new \Fabfuel\Prophiler\Profiler();
```

#####2. Add the profiler to the dependency injection container
Add the profiler instance to the DI container, that other plugins and adapters can use it accros the application. This should be done in or after your general DI setup.
	
```php
$di->setShared('profiler', $profiler);
```

#####3. Initialize the plugin manager
The plugin manager registers all included framework plugins automatically and attaches them to the events manager.  

```php
$pluginManager = new \Fabfuel\Prophiler\Plugin\Manager\Phalcon($profiler);
$pluginManager->register();
```

#####4. Initialize and register the Toolbar

To visualize the profiling results, you have to initialize and render the Prophiler Toolbar. This component will take care for rendering all results of the Profiler benchmarks and other data collectors. Put that at the end of the frontcontroller.

You can also add other data collectors to the Toolbar, to show e.g. request data like in this example.

```php
$toolbar = new \Fabfuel\Prophiler\Toolbar($profiler);
$toolbar->addDataCollector(new \Fabfuel\Prophiler\DataCollector\Request());
echo $toolbar->render();
```

You can also easily create you own data collectors, by implementing the DataCollectorInterface and adding an instance to the Toolbar at this point.

```php
...
$toolbar->addDataCollector(new \My\Custom\DataCollector());
...
```

## Custom Benchmarks

You can easily add custom benchmarks to your code:

```php
$benchmark = $profiler->start('\My\Class::doSomething', ['additional' => 'information'], 'My Component');
...
$profiler->stop($benchmark);
```

#####Or stop without passing the benchmark
In some scenarios (e.g. custom adapters) it might be hard to pass the received benchmark to the ```stop()``` method. Alternatively you can omit the ```$benchmark``` parameter. In this that case, the profiler simply stops the last started benchmark, but it is not possible to run overlapping benchmarks.

```php
$profiler->start('\My\Class::doSomeOtherThing', ['additional' => 'information'], 'My Component');
...
$profiler->stop();
```



## Tips

To render the toolbar as very last action, you can also register it as shutdown function:

```php
register_shutdown_function([$toolbar, 'render']);
```

To record session writing, you can commit or write & close the session before rendering the toolbar
    
```php
session_commit();

session_write_close() // same behavior
```

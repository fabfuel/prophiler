#Prophiler - A Phalcon Profiler & Dev Toolbar

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/b/fabfuel/prophiler/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/b/fabfuel/prophiler/?branch=develop)
[![Code Coverage](https://scrutinizer-ci.com/b/fabfuel/prophiler/badges/coverage.png?b=develop)](https://scrutinizer-ci.com/b/fabfuel/prophiler/?branch=develop)
[![Build Status](https://scrutinizer-ci.com/b/fabfuel/prophiler/badges/build.png?b=develop)](https://scrutinizer-ci.com/b/fabfuel/prophiler/build-status/develop)


## Installation
You should use composer to install the Profiler. Just add it as dependency:

    "require": {
       	"fabfuel/prophiler": "dev-master",
    }

## Setup
Setting up the Prophiler and the Developer Toolbar can be done by three simple steps.

#####1. Initialize the Profiler (as soon as possible)
Generally it makes sense to initialize the profiler as soon as possible, to measure as much execution time as you can. You should initialize the profiler in your public/index.php or a separat bootstrap file right after requiring the Composer autoloader.

	$profiler = new \Fabfuel\Prophiler\Profiler();

#####2. Add the profiler to the dependency injection container
Add the profiler instance to the DI container, that other plugins and adapters can use it accros the application. This should be done in or after your general DI setup.
	
    $di->setShared('profiler', $profiler);

#####3. Initialize and register the Toolbar

To visualize the profiling results, you have to initialize and render the Prophiler Toolbar. This component will take care for rendering all results of the Profiler benchmarks and other data collectors. The register() method registers the default Plugins in the EventsManager inside your DI container.

	$toolbar = new \Fabfuel\Prophiler\Toolbar($profiler);
	$toolbar->register();

The render() method creates the real HTML, CSS and JavaScript output. Put that at the end of your front controller (probably public/index.php)

	$toolbar->render();

To render the toolbar as very last action, you can register it as shutdown function:

    register_shutdown_function([$toolbar, 'render']);

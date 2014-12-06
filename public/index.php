<!DOCTYPE HTML>
<html>
	<?php include "partials/head.php"; ?>

	<body class="homepage">

    <!-- Header -->
    <div id="header-wrapper">
        <div id="header" class="container">
            <?php require 'partials/navigation.php'; ?>
        </div>

        <!-- Hero -->
        <section id="hero" class="container">
            <header>
                <h2>
                    Prophiler
                    </h2>
                <h3>
                    A PHP Profiler & Developer Toolbar
                </h3>
            </header>
            <p>
                Designed and built by <a href="http://github.com/fabfuel">Fabfuel</a>.
                <br />
                Released for free under
                the <a href="https://raw.githubusercontent.com/fabfuel/prophiler/develop/LICENSE.md">BSD-3 license</a>.</p>
            <ul class="actions">
                <li><a href="how-it-works.php" class="button">See how it works</a></li>
                <li><a href="demo.php" class="button">Or try a demo</a></li>
            </ul>
        </section>

    </div>
			

    <!-- Main -->
    <div class="wrapper">
        <div class="container" id="main">

            <!-- Content -->
                <article id="content">
                    <header>
                        <h2>Visual candy to sweeten frustrating debugging work</h2>
                    </header>
                    <p>Prophiler was built to provide a powerful tool for visualizing what's going on in your PHP
                        application. The timeline is inspired by modern browser's networking tabs and gives you a
                        beautiful and unique overview of processes happening in the background during the run of your
                        application. It's just the most beautiful PHP profiler out there.</p>
                </article>

            <div class="row features">
                <section class="4u 12u(2) feature">
                    <div class="image-wrapper first">
                        <a href="/demo.php" class="image featured"><img src="img/timeline.png" alt=""></a>
                    </div>
                    <header>
                        <h3>Timeline</h3>
                    </header>
                    <p>Inspired by modern browser's network tabs, the timeline provides a unique, detailed and beautiful overview of what's going on under the hood.</p>
                    <ul class="actions">
                        <li><a href="/demo.php" class="button">Show me the demo</a></li>
                    </ul>
                </section>
                <section class="4u 12u(2) feature">
                    <div class="image-wrapper">
                        <a href="/demo.php" class="image featured"><img src="img/logs.png" alt=""></a>
                    </div>
                    <header>
                        <h3>Logs</h3>
                    </header>
                    <p>With its PSR-3 compliant logger adapter, you can plug in Prophiler to your existing logging infrastructure and see all messages with a single click.</p>
                    <ul class="actions">
                        <li><a href="/demo.php" class="button">Show me the demo</a></li>
                    </ul>
                </section>
                <section class="4u 12u(2) feature">
                    <div class="image-wrapper">
                        <a href="/demo.php" class="image featured"><img src="img/queries.png" alt=""></a>
                    </div>
                    <header>
                        <h3>Database insights</h3>
                    </header>
                    <p>See exactly what queries and commands are processed by your MongoDB or MySQL database. In addition you get the execution time and memory consumption.</p>
                    <ul class="actions">
                        <li><a href="/demo.php" class="button">Show me the demo</a></li>
                    </ul>
                </section>
            </div>
        </div>
    </div>

    <!-- Contribute -->
    <div id="promo-wrapper">
        <section id="promo">
            <h2>Would you like to contribute to Prophiler?</h2>
            <a href="https://github.com/fabfuel/prophiler" class="button">Fork it on <img src="img/github_logo.png"></a>
        </section>
    </div>


    <!-- Main -->
    <div class="wrapper">
        <div class="container" id="phalcon">

            <!-- Content -->
            <article id="built-for-phalcon">
                <header>
                    <h2>Built for Phalcon</h2>
                </header>
                <p>Prophiler was initially built for the <a href="http://phalconphp.com">Phalcon PHP Framework</a>. It comes bundled with adapters for several components which give you a powerful starting point. This let's you set up the profiling of your Phalcon application with <a href="/how-it-works.php">some simple steps</a>. Bundled adapters and data-collectors are:</p>
            </article>

            <div class="row features">
                <section class="4u 12u(2) feature">
                    <header>
                        <h3>Dispatcher</h3>
                    </header>
                    <p>Benchmarks the routing and dispatching of the request to the appropriate controller action.</p>
                </section>
                <section class="4u 12u(2) feature">
                    <header>
                        <h3>View</h3>
                    </header>
                    <p>Gives you detailed insights of how many views (and partials) were rendered, how long each needed and how much memory they consumed.</p>
                </section>
                <section class="4u 12u(2) feature">
                    <header>
                        <h3>Database</h3>
                    </header>
                    <p>If you use the Phalcon ORM or ODM, you immediately get information about all queries and commands sent to your database.</p>
                </section>
            </div>
        </div>
    </div>

    <div class="wrapper">
        <div class="container" id="phalcon">

            <!-- Content -->
            <article id="built-for-phalcon">
                <header>
                    <h2>Other adapters and data collectors</h2>
                </header>
                <p>Prophiler comes with some other adapters and data-collectors, for integrating easily in your application. This list is going to be continued!</p>
            </article>

            <div class="row features">
                <section class="6u 12u(2) feature">
                    <header>
                        <h3>Fabfuel\Mongo</h3>
                    </header>
                    <p>If you use my MongoDB document mapper, you can now easily see all database interactions (finds, inserts, updates, removes, even aggregations) in the Prophiler timeline.</p>
                </section>
                <section class="6u 12u(2) feature">
                    <header>
                        <h3>Request</h3>
                    </header>
                    <p>This data collector provides useful request information from the environment variables. You have easy access to all $_GET, $_POST, $_COOKIE and $_SERVER information.</p>
                </section>
            </div>
        </div>
    </div>

    <?php include "partials/footer.php"; ?>

	</body>
</html>

<?php

require dirname(__DIR__) . '/vendor/autoload.php';

// Gets README from GitHub
$readme_content = file_get_contents('https://raw.githubusercontent.com/fabfuel/prophiler/develop/README.md');

$parsedown = new Parsedown();
?>

<!DOCTYPE HTML>
<html>
    <?php include "partials/head.php"; ?>

    <link rel="stylesheet" href="/css/prism.css" />

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
                            <h2>How does the Prophiler Toolbar work</h2>
                            <p>Head on to <a href="https://github.com/fabfuel/prophiler">Github</a> to see the source</p>
                        </header>

                        <?= $parsedown->text($readme_content); ?>

                    </article>
				</div>
			</div>

    <?php include "partials/footer.php"; ?>

    <script src="/js/prism.min.js"></script>

	</body>
</html>

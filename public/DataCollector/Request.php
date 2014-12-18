<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 26.11.14, 07:39
 */
namespace Fabfuel\Prophiler\Demo\DataCollector;

class Request extends \Fabfuel\Prophiler\DataCollector\Request
{
    public function getData()
    {

        return array(
            'GET' => $_GET,
            'POST' => $_POST,
            'COOKIE' => $_COOKIE,
            'SERVER' => array(
                'DOCUMENT_ROOT' => '/foo/bar/prophiler/demo',
                'SERVER_PROTOCOL' => 'HTTP/1.1',
                'SERVER_NAME' => 'foo.bar',
                'SERVER_PORT' => '80',
                'REQUEST_URI' => '/',
                'REQUEST_METHOD' => 'GET',
                'SCRIPT_NAME' => '/index.php',
                'SCRIPT_FILENAME' => '/foo/bar/prophiler/demo/index.php',
                'PHP_SELF' => '/index.php',
                'HTTP_HOST' => 'foo.bar:80',
                'HTTP_CONNECTION' => 'keep-alive',
                'HTTP_CACHE_CONTROL' => 'max-age=0',
                'HTTP_ACCEPT' => $_SERVER['HTTP_ACCEPT'],
                'HTTP_USER_AGENT' => $_SERVER['HTTP_ACCEPT'],
                'HTTP_ACCEPT_ENCODING' => $_SERVER['HTTP_ACCEPT_ENCODING'],
                'HTTP_ACCEPT_LANGUAGE' => $_SERVER['HTTP_ACCEPT_LANGUAGE'],
                'HTTP_COOKIE' => $_SERVER['HTTP_COOKIE']
            ),
        );
    }
}

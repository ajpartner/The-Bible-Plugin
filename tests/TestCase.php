<?php

namespace Tests;

use CodeZone\Bible\CodeZone\Router\Middleware\HandleErrors;
use CodeZone\Bible\CodeZone\Router\Middleware\HandleRedirects;
use CodeZone\Bible\CodeZone\Router\Middleware\Render;
use CodeZone\Bible\CodeZone\Router\Middleware\Stack;
use CodeZone\Bible\Illuminate\Http\Request;
use WP_UnitTestCase;
use function CodeZone\Bible\container;

abstract class TestCase extends WP_UnitTestCase {
	public function setUp(): void {
		global $wpdb;
		$wpdb->query( 'START TRANSACTION' );
		parent::setUp();
	}

	public function tearDown(): void {
		global $wpdb;
		$wpdb->query( 'ROLLBACK' );
		parent::tearDown();
	}

	/**
	 * Sends a GET request to the specified URI with optional parameters and headers.
	 *
	 * @param string $uri The URI to send the GET request to.
	 * @param mixed $parameters The optional parameters to include in the GET request.
	 * @param array $headers The optional headers to include in the GET request.
	 *
	 * @return mixed The response returned from the GET request.
	 */
	public function get( $uri, $parameters, array $headers = [] ) {
		return $this->request( 'GET', $uri, $parameters, $headers );
	}

	/**
	 * The request method sends a request to a specified URI using the specified HTTP method and additional parameters.
	 *
	 * @param string $method The HTTP method for the request.
	 * @param string $uri The URI to send the request to.
	 * @param array $parameters An array of parameters to include in the request.
	 * @param array $cookies An array of cookies to include in the request.
	 * @param array $files An array of files to include in the request.
	 * @param array $server An array of server variables to include in the request.
	 * @param mixed $content The content to send with the request.
	 *
	 * @return mixed The response from the request.
	 */
	public function request( $method, $uri, array $parameters = [], $headers = [], array $cookies = [], array $files = [], array $server = [], $content = null ) {
		$initial_request = container()->make( Request::class );
		$request         = Request::create( $uri, $method, $parameters, $cookies, $files, $server, $content );
		foreach ( $headers as $key => $value ) {
			$request->headers->set( $key, $value );
		}
		$blacklisted_middleware = [
			HandleErrors::class,
			HandleRedirects::class,
			Render::class
		];

		container()->bind( Request::class, function () use ( $request ) {
			return $request;
		} );

		add_filter( 'codezone/bible/middleware', function ( $stack ) use ( $blacklisted_middleware ) {
			return $stack->filter( function ( $middleware ) use ( $blacklisted_middleware ) {
				return ! in_array( $middleware, $blacklisted_middleware );
			} );
		} );
		$stack    = apply_filters( 'codezone/bible/middleware', container()->make( Stack::class ) );
		$response = $stack->run();

		container()->bind( Request::class, function () use ( $initial_request ) {
			return $initial_request;
		} );

		return $response;
	}

	/**
	 * Send a POST request to the specified URI with the given data and headers.
	 *
	 * @param string $uri The URI to send the request to.
	 * @param array $data An array of data to include in the request body.
	 * @param array $headers An array of headers to include in the request.
	 *
	 * @return mixed The response from the request.
	 */
	public function post( $uri, array $data = [], array $headers = [] ) {
		return $this->request( 'POST', $uri, $data, $headers );
	}
}

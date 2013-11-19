<?php
/**
 * @author     Hannes Van De Vreken <vandevreken.hannes@gmail.com>
 * @copyright  Copyright (c) 2013 The authors
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */

require_once 'app.php';

use Mockery as m;
use hannesvdvreken\OAuth\OAuth;
use Illuminate\support\Facades\Facade;

class OAuthTest extends PHPUnit_Framework_TestCase
{
    private $app;
    private $url = 'http://example.org/redirect';
    private $service = 'Facebook';
    private $client_id = 'client_id';
    private $client_secret = 'client_secret';
    private $credentials_mock;
    private $storage_mock;
    private $scope;

    public function setUp()
    {
        // mock container objects
        $this->app = new FakeApp();
        $this->app['config'] = $this->mock_config();
        $this->app['app'] = $this->mock_app();
    }

    public function tearDown()
    {
        // clear cached instances
        Facade::clearResolvedInstances();
        m::close();
    }

    public function testConfig()
    {
        // assign application container
        Facade::setFacadeApplication($this->app);

        // create oauth object
        $oauth = new OAuth($this->mock_factory());

        // act
        $service = $oauth->consumer($this->service, $this->url);
    }

    public function testDefaultURL()
    {
        // mock url
        $url_mock = m::mock('Illuminate\Routing\UrlGenerator');
        $url_mock->shouldReceive('current')->andReturn($this->url);
        $this->app['url'] = $url_mock;

        // assign application container
        Facade::setFacadeApplication($this->app);

        // create oauth object
        $oauth = new OAuth($this->mock_factory());

        // act
        $service = $oauth->consumer($this->service);
    }

    /**
     * Mocks the config repository
     * @return \Mockery\Expectation
     */
    protected function mock_config()
    {
        $service = $this->service;

        $config = m::mock('Illuminate\Config\Repository');
        $config->shouldReceive('get')
               ->with("oauth.consumers.$service.client_id")
               ->andReturn($this->client_id);
        $config->shouldReceive('get')
               ->with("oauth.consumers.$service.client_secret")
               ->andReturn($this->client_secret);
        $config->shouldReceive('get')
               ->with("oauth.consumers.$service.scope", array())
               ->andReturn(array());
        $config->shouldReceive('get')
               ->with('oauth.client', 'StreamClient')
               ->andReturn('StreamClient');

        return $config;
    }

    /**
     * Mocks the application container
     * @return \Mockery\Expectation
     */
    protected function mock_app()
    {
        // arrange
        $credentials = array(
            'consumerId'     => $this->client_id,
            'consumerSecret' => $this->client_secret,
            'callbackUrl'    => $this->url,
        );

        // credentials mock
        $this->credentials_mock = m::mock('\OAuth\Common\Consumer\Credentials');
        $this->credentials_mock->shouldReceive('getCallbackUrl')->andReturn($this->url);
        $this->credentials_mock->shouldReceive('getConsumerId')->andReturn($this->client_id);
        $this->credentials_mock->shouldReceive('getConsumerSecret')->andReturn($this->client_secret);

        // storage mock
        $this->storage_mock = m::mock('\OAuth\Common\Storage\TokenStorageInterface');
        $this->client_mock = m::mock('\OAuth\Common\Http\Client\ClientInterface.php');

        // app mock
        $app_mock = m::mock('\Illuminate\Container\Container');
        $app_mock->shouldReceive('make')
                 ->with('\OAuth\Common\Consumer\Credentials', $credentials)
                 ->andReturn($this->credentials_mock);

        $app_mock->shouldReceive('make')
                 ->with('\hannesvdvreken\OAuth\Storage\LaravelSession')
                 ->andReturn($this->storage_mock);

        $app_mock->shouldReceive('make')
                 ->with('\OAuth\Common\Http\Client\StreamClient')
                 ->andReturn($this->client_mock);

        return $app_mock;
    }

    /**
     * Mocks the Service Factory
     * @return \Mockery\Expectation
     */
    protected function mock_factory()
    {
        $factory_mock = m::mock('OAuth\ServiceFactory');
        $factory_mock->shouldReceive('createService')
                     ->with($this->service, $this->credentials_mock, $this->storage_mock, $this->scope);

        return $factory_mock;
    }
}

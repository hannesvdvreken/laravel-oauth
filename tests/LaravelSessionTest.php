<?php
/**
 * @author     Hannes Van De Vreken <vandevreken.hannes@gmail.com>
 * @copyright  Copyright (c) 2013 The authors
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */

require_once 'app.php';

use hannesvdvreken\OAuth\Storage\LaravelSession;
use OAuth\OAuth2\Token\StdOAuth2Token;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Session;
use Illuminate\Session\SessionManager;

class LaravelSessionTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        // set it
        $this->storage = new LaravelSession();

        // arrange fake storage
        $this->app = new FakeApp();

        // laravel array session storage
        $session_manager = new SessionManager($this->app);
        $array_driver = $session_manager->driver('array');

        // assing to container
        $this->app['session'] = $array_driver;

        // set fake container
        Facade::setFacadeApplication($this->app);
    }

    public function tearDown()
    {
        // delete
        Session::flush();
        unset($this->storage);
    }

    /**
     * Check that the token gets properly stored.
     */
    public function testStorage()
    {
        // arrange
        $service_1 = 'Facebook';
        $service_2 = 'Foursquare';

        $token_1 = new StdOAuth2Token('access_1', 'refresh_1', StdOAuth2Token::EOL_NEVER_EXPIRES, array('extra' => 'param'));
        $token_2 = new StdOAuth2Token('access_2', 'refresh_2', StdOAuth2Token::EOL_NEVER_EXPIRES, array('extra' => 'param'));

        // act
        $this->storage->storeAccessToken($service_1, $token_1);
        $this->storage->storeAccessToken($service_2, $token_2);

        // assert
        $extraParams = $this->storage->retrieveAccessToken($service_1)->getExtraParams();
        $this->assertEquals('param', $extraParams['extra']);
        $this->assertEquals($token_1, $this->storage->retrieveAccessToken($service_1));
        $this->assertEquals($token_2, $this->storage->retrieveAccessToken($service_2));
    }

    /**
     * Test hasAccessToken.
     */
    public function testHasAccessToken()
    {
        // arrange
        $service = 'Facebook';
        $this->storage->clearToken($service);

        // act
        // assert
        $this->assertFalse($this->storage->hasAccessToken($service));
    }

    /**
     * Check that the token gets properly deleted.
     */
    public function testStorageClears()
    {
        // arrange
        $service = 'Facebook';
        $token = new StdOAuth2Token('access', 'refresh', StdOAuth2Token::EOL_NEVER_EXPIRES, array('extra' => 'param'));

        // act
        $this->storage->storeAccessToken($service, $token);
        $this->storage->clearToken($service);

        // assert
        $this->setExpectedException('OAuth\Common\Storage\Exception\TokenNotFoundException');
        $this->storage->retrieveAccessToken($service);
    }
}

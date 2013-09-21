<?php
/**
 * @author     Hannes Van De Vreken <vandevreken.hannes@gmail.com>
 * @copyright  Copyright (c) 2013 The authors
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */

require_once __DIR__.'/../vendor/autoload.php';

use Mockery as m;
use hannesvdvreken\OAuth\OAuthServiceProvider;

class ServiceProviderTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testRegister()
    {
        // mock app
        $app = m::mock('\Illuminate\Foundation\Application');
        
        $app->shouldReceive('bind')
            ->with('oauth', m::type('callable'));

        $app->shouldReceive('bind')
            ->with('\\OAuth\\Common\\Consumer\\Credentials', m::type('callable'));
        
        $service_provider = new OAuthServiceProvider($app);

        // act
        $result = $service_provider->register();

        // assert
        $this->assertEquals(null, $result);
    }
}
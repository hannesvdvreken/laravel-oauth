<?php
/**
 * @author     Hannes Van De Vreken <vandevreken.hannes@gmail.com>
 * @copyright  Copyright (c) 2013 The authors
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */

namespace hannesvdvreken\OAuth\Storage;

use OAuth\Common\Token\TokenInterface;
use OAuth\Common\Storage\Exception\TokenNotFoundException;
use OAuth\Common\Storage\Exception\AuthorizationStateNotFoundException;
use OAuth\Common\Storage\TokenStorageInterface;
use Illuminate\Support\Facades\Session;

class LaravelSession implements TokenStorageInterface
{
    private $sessionVariableName;
    private $stateVariableName;

    public function __construct($sessionVariableName = 'oauth_token', $stateVariableName = 'oauth_state')
    {
        $this->sessionVariableName = $sessionVariableName;
        $this->stateVariableName = $stateVariableName;
    }

    /**
     * {@inheritDoc}
     */
    public function retrieveAccessToken($service)
    {
        if ($this->hasAccessToken($service)) {
            // get from session
            $tokens = Session::get($this->sessionVariableName);

            // one item
            return $tokens[$service];
        }

        throw new TokenNotFoundException('Token not found in session, are you sure you stored it?');
    }

    /**
     * {@inheritDoc}
     */
    public function storeAccessToken($service, TokenInterface $token)
    {
        // get previously saved tokens
        $tokens = Session::get($this->sessionVariableName);

        if (!is_array($tokens)) {
            $tokens = array();
        }

        $tokens[$service] = $token;

        // save
        Session::put($this->sessionVariableName, $tokens);

        // allow chaining
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function hasAccessToken($service)
    {
        // get from session
        $tokens = Session::get($this->sessionVariableName);

        return is_array($tokens)
            && isset($tokens[$service])
            && $tokens[$service] instanceof TokenInterface;
    }

    /**
     * {@inheritDoc}
     */
    public function clearToken($service)
    {
        // get previously saved tokens
        $tokens = Session::get($this->sessionVariableName);

        if (is_array($tokens) && array_key_exists($service, $tokens)) {
            unset($tokens[$service]);

            // Replace the stored tokens array
            Session::put($this->sessionVariableName, $tokens);
        }

        // allow chaining
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function clearAllTokens()
    {
        Session::forget($this->sessionVariableName);

        // allow chaining
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function retrieveAuthorizationState($service)
    {
        if ($this->hasAuthorizationState($service)) {
            // get from session
            $states = Session::get($this->stateVariableName);

            // one item
            return $states[$service];
        }

        throw new AuthorizationStateNotFoundException('State not found in session, are you sure you stored it?');
    }

    /**
     * {@inheritDoc}
     */
    public function storeAuthorizationState($service, $state)
    {
        // get previously saved tokens
        $states = Session::get($this->stateVariableName);

        if (!is_array($states)) {
            $states = array();
        }

        $states[$service] = $state;

        // save
        Session::put($this->stateVariableName, $states);

        // allow chaining
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function hasAuthorizationState($service)
    {
        // get from session
        $states = Session::get($this->stateVariableName);

        return is_array($states)
        && isset($states[$service])
        && null !== $states[$service];
    }

    /**
     * {@inheritDoc}
     */
    public function clearAuthorizationState($service)
    {
        // get previously saved tokens
        $states = Session::get($this->stateVariableName);

        if (is_array($states) && array_key_exists($service, $states)) {
            unset($states[$service]);

            // Replace the stored tokens array
            Session::put($this->stateVariableName, $states);
        }

        // allow chaining
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function clearAllAuthorizationStates()
    {
        Session::forget($this->stateVariableName);

        // allow chaining
        return $this;
    }
}

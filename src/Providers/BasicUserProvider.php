<?php
/**
 * Created by PhpStorm.
 * User: ms
 * Date: 14-03-2019
 * Time: 04:54 AM
 */

namespace MS\Provider;
use \Illuminate\Contracts\Auth\Authenticatable;

class BasicUserProvider implements Authenticatable
{
    private $conn;

    private $username;
    private $password;
    protected $rememberTokenName = 'remember_token';

    public function __construct(Array $conn)
    {
        $this->conn = $conn;
    }

    /**
     * Fetch user by Credentials
     *
     * @param array $credentials
     * @return Illuminate\Contracts\Auth\Authenticatable
     */
    public function fetchUserByCredentials(Array $credentials)
    {
        $arr_user = $this->conn->find('users', ['username' => $credentials['username']]);

        if (! is_null($arr_user)) {
            $this->username = $arr_user['username'];
            $this->password = $arr_user['password'];
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     * @see \Illuminate\Contracts\Auth\Authenticatable::getAuthIdentifierName()
     */
    public function getAuthIdentifierName()
    {
        return "username";
    }

    /**
     * {@inheritDoc}
     * @see \Illuminate\Contracts\Auth\Authenticatable::getAuthIdentifier()
     */
    public function getAuthIdentifier()
    {
        return $this->{$this->getAuthIdentifierName()};
    }

    /**
     * {@inheritDoc}
     * @see \Illuminate\Contracts\Auth\Authenticatable::getAuthPassword()
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * {@inheritDoc}
     * @see \Illuminate\Contracts\Auth\Authenticatable::getRememberToken()
     */
    public function getRememberToken()
    {
        if (! empty($this->getRememberTokenName())) {
            return $this->{$this->getRememberTokenName()};
        }
    }

    /**
     * {@inheritDoc}
     * @see \Illuminate\Contracts\Auth\Authenticatable::setRememberToken()
     */
    public function setRememberToken($value)
    {
        if (! empty($this->getRememberTokenName())) {
            $this->{$this->getRememberTokenName()} = $value;
        }
    }

    /**
     * {@inheritDoc}
     * @see \Illuminate\Contracts\Auth\Authenticatable::getRememberTokenName()
     */
    public function getRememberTokenName()
    {
        return $this->rememberTokenName;
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  array  $credentials
     * @return bool
     */
    public function validateCredentials(UserContract $user, array $credentials)
    {
        $password = bcrypt($credentials['password'] . $user->salt);
        return $this->hasher->check($password, $user->getAuthPassword());
    }

}
<?php

namespace SimPas\HttpRequest\CookieJar;

use SimPas\Configuration\Configuration;

class CookieJar
{
    use Configuration;

    /**
     * @param $name
     * @param $value
     * @param int $expire
     * @return bool
     */
    public function set($name, $value, int $expire = 86400): bool
    {
        return setcookie($name, $value, time() + $expire, $this->config()['cookie_path'], $this->config()['cookie_domain'], $this->config()['cookie_secure']);
    }

    /**
     * @param $name
     * @return false|string
     */
    public function get($name)
    {
        if (isset($_COOKIE[$name])) {
            return trim(str_replace(["\0", "\n", "\t", "\s"], '', $_COOKIE[$name]));
        }

        return false;
    }

    /**
     * @param $name
     * @return bool
     */
    public function destroy($name): bool
    {
        if (isset($_COOKIE[$name])) {
            unset($_COOKIE[$name]);
        }

        return setcookie($name, null, -1, $this->config()['cookie_path'], $this->config()['cookie_domain'], $this->config()['cookie_secure']);
    }
}

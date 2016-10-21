<?php

namespace App\Units\Core\Http\Middleware;

use Closure;

/**
 * Class RedirectIfWrongUrlOrProtocol.
 */
class RedirectIfWrongUrlOrProtocol
{
    /** @var Request */
    protected $request;

    public function handle($request, Closure $next)
    {
        if (!app()->runningInConsole()) {
            $this->request = $request;

            $this->trustProxies();

            if (!$this->isTheRightDomain() || !$this->isTheRightProtocol()) {
                return $this->redirect();
            }
        }

        return $next($request);
    }

    protected function trustProxies()
    {
        // trust proxies before anything
        $this->request->setTrustedProxies($this->request->getClientIps());
    }

    protected function getDomain()
    {
        return preg_replace('/^http(s)?:\/\//', null, $this->request->root());
    }

    protected function redirect()
    {
        $protocol = config('app.secure') ? 'https://' : 'http://';

        $currentDomain = $this->getDomain();

        $domain = explode('.', $currentDomain);
        $domain = $domain[0] == 'admin' ? env('APP_DOMAIN_ADMIN') : env('APP_DOMAIN');

        $path = $this->request->path() == '/' ? '' : '/' . $this->request->path();

        return redirect()->to($protocol . $domain . $path);
    }

    protected function isTheRightDomain()
    {
        $currentDomain = $this->getDomain();

        $domain = explode('.', $currentDomain);
        $defaultDomain = $domain[0] == 'admin' ? env('APP_DOMAIN_ADMIN') : env('APP_DOMAIN');

        return $defaultDomain == $currentDomain;
    }

    protected function isTheRightProtocol()
    {
        $shouldBeSecure = config('app.secure');
        $isSecure = $this->request->isSecure();

        return $shouldBeSecure == $isSecure;
    }
}

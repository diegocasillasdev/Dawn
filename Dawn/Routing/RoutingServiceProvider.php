<?php

namespace Dawn\Routing;

use Dawn\ServiceProvider;

class RoutingServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerRouter();
    }

    private function registerRouter()
    {
        $router = new Router($this->app, [ROUTES, ROUTES_API]);
        $this->app->bind('router', $router);
    }
}
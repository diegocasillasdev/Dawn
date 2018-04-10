<?php

namespace Dawn\Database;

use Dawn\ServiceProvider;
use Dawn\Database\Connection;

class DatabaseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerConnection();
        $this->registerQueryBuilder();
    }

    private function registerConnection()
    {
        $connection = new Connection($this->app);
        $connection = $connection->make();
        $this->app->bind('connection', $connection);
    }

    public function registerQueryBuilder()
    {
        $this->app->bind('query builder', new QueryBuilder($this->app, $this->app->get('connection')));
    }
}
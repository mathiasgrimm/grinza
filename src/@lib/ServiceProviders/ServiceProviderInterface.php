<?php namespace Grinza\ServiceProviders;

use Grinza\Application;

interface ServiceProviderInterface
{
    public function setApplication(Application $app);
    public function boot();
    public function register();
}
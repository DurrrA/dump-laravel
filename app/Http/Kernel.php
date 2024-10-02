<?php
// app/Http/Kernel.php

class Kernel {
    protected $routeMiddleware = [
        // Other middleware
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
    ];
    
}
<?php

declare(strict_types=1);

namespace app\common\controller;

use app\common\install\Install;

class Test
{
    private $obj;
    public function __construct()
    {
        $this->obj = new Install();
    }
    public function index()
    {
        $this->obj->install();
        return 123;
    }
}

<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations;

    /**
     * @var array
     */
    protected $credentials = [];

    /**
     * TestCase constructor.
     * @param null|string $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $name = str_random();
        $cnp = str_random(60);

        $this->credentials = compact('name', 'cnp');
    }

    public function setUp()
    {
        parent::setUp();

        Artisan::call('db:seed');
    }
}

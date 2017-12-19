<?php

namespace Test\Unit;

use RuntimeException;
use Test\TestCase;

class NetBatchTest extends TestCase
{
    /**
     * net
     * 
     * @var Web3\Net
     */
    protected $net;

    /**
     * setUp
     * 
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->net = $this->web3->net;
    }

    /**
     * testBatch
     * 
     * @return void
     */
    public function testBatch()
    {
        $net = $this->net;

        $net->batch(true);
        $net->version();
        $net->listening();

        $net->provider->execute(function ($err, $data) {
            if ($err !== null) {
                return $this->fail($err->getMessage());
            }
            $this->assertTrue(is_string($data[0]->result));
            $this->assertTrue(is_bool($data[1]->result));
        });
    }
}
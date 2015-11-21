<?php


class IndexTest extends TestCase
{
    public function testIndex()
    {
        $this->visit('/')
             ->see('日新手机客户端');
    }
}

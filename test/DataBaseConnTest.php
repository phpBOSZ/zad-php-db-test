<?php

require('../app/DataBaseConn.php');

use PHPUnit\Framework\TestCase;

class DataBaseConnTest extends TestCase
{

    public $instance;
    public function setUp() : void {
//        docker run -p 5200:3306 --name some-mysql -e MYSQL_ROOT_PASSWORD=root -e MYSQL_DATABASE=test -d mysql:8.2.0
        $this->instance = new DataBaseConn("0.0.0.0","root","root","test",5200);
    }
    public function tearDown() : void {
        unset($this->instance);
    }

    public function testDb() {

        $this->instance->schema();

        $this->assertEquals(true, $this->instance->put("jo",'kolumna1, kolumna2, kolumna3','5,3,6'));
        $this->assertEquals(true, $this->instance->update("jo",'kolumna1 = 90','kolumna1 = 5'));
        $this->assertEquals(true, $this->instance->get('jo','kolumna1, kolumna2, kolumna3','kolumna2=3'));
        $this->assertEquals(true, $this->instance->delete('jo','kolumna2=3'));

    }
}
?>
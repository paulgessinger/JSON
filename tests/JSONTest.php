<?php


use PG\JSON;
use PG\JSON\Exception\SyntaxException;

class JSONTest extends PHPUnit_Framework_TestCase {

    public function testJsonEncode() {

        // empty
        $enc = JSON::encode(array()) ;
        $this->assertEquals('[]', $enc) ;

        // object
        $enc = JSON::encode(new stdClass()) ;
        $this->assertEquals('{}', $enc) ;

    }

    public function testJsonDecode() {
        // mismatch
        try {
            $dec = JSON::decode('{"abc":1234') ;
            $this->fail() ;
        }
        catch(SyntaxException $e) {
            $this->assertEquals('JSON_ERROR_SYNTAX', $e->getMessage()) ;
            $this->assertEquals(JSON_ERROR_SYNTAX, $e->getCode()) ;
        }

        // valid
        $dec = JSON::decode('{"abc": 1234}') ;
        $this->assertEquals(array('abc' => 1234), $dec) ;

        // cycle
        $test = array(
            'yellow' => 'flowers',
            "hallo" => 1244,
            'float' => 0.467,
            array(3, 4, 6, 'siebzehn')
        ) ;
        $this->assertEquals($test, JSON::decode(JSON::encode($test))) ;


    }

    public function testBeautify() {
        // does beautify destroy json strings?
        $test = array(
            'yellow' => 'flowers',
            "hallo" => 1244,
            'float' => 0.467,
            array(3, 4, 6, 'siebzehn')
        ) ;
        $this->assertEquals($test,
            JSON::decode(
                JSON::beautify(
                    JSON::encode(
                        $test
                    )
                )
            )
        ) ;
    }

}
 
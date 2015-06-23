<?php

use XmlValidator\XmlValidator;

class InvalidArgumentExceptionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessageRegExp *it is empty*
     */
    public function testEmptyXmlShouldThrowExceptionInvalidArgument()
    {
        $v = new XmlValidator();
        $xml = "";
        $schema = "";

        $v->validate($xml, $schema);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessageRegExp *valid path to XSD file*
     */
    public function testNotValidSchemaPathShouldThrowExceptionInvalidArgument()
    {
        $v = new XmlValidator();
        $xml = "<package>validator</package>";
        $schema = "";

        $v->validate($xml, $schema);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessageRegExp *valid path to XSD file*
     */
    public function testEmptySchemaShouldThrowExceptionInvalidArgument()
    {
        $v = new XmlValidator();
        $xml = "<package>validator</package>";
        $schema = "";

        $v->validate($xml, $schema);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Document types are not allowed.
     */
    public function testDoctypeShouldThrowExceptionInvalidArgument()
    {
        $v = new XmlValidator();
        $xml = "<!DOCTYPE html><package>validator</package>";
        $schema = "";

        $v->validate($xml, $schema);
    }
}

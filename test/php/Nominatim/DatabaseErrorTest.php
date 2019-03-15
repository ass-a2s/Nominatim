<?php

namespace Nominatim;

require_once(CONST_BasePath.'/lib/init-website.php');
require_once(CONST_BasePath.'/lib/DatabaseError.php');

class DatabaseErrorTest extends \PHPUnit\Framework\TestCase
{

    public function testSqlMessage()
    {
        $oSqlStub = $this->getMockBuilder(PDOException::class)
                    ->setMethods(array('getMessage'))
                    ->getMock();

        $oSqlStub->method('getMessage')
                ->willReturn('Unknown table.');

        $oErr = new DatabaseError('Sql error', 123, null, $oSqlStub);
        $this->assertEquals('Sql error', $oErr->getMessage());
        $this->assertEquals(123, $oErr->getCode());
        $this->assertEquals('Unknown table.', $oErr->getSqlError());
    }

    public function testSqlObjectDump()
    {
        $oErr = new DatabaseError('Sql error', 123, null, array('one' => 'two'));
        $this->assertRegExp('/two/', $oErr->getSqlDebugDump());
    }
}

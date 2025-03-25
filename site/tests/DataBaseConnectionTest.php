<?php

namespace App\Tests;

spl_autoload_register(function ($className) {
    $baseDir = __DIR__ . '/../src/';
    $filePath = str_replace(['App\\', '\\'], ['', '/'], $className) . '.php';
    $fullPath = $baseDir . $filePath;
    if (file_exists($fullPath)) {
        require $fullPath;
    } else {
        error_log("Autoload failed: $fullPath not found.");
    }
});

use App\Services\DataBaseConnection;
use PHPUnit\Framework\TestCase;
use PDO;
use Exception;

class DataBaseConnectionTest extends TestCase
{
    private $dbConnection;

    protected function setUp(): void
    {
        $this->dbConnection = new DataBaseConnection(
            'localhost',
            'root',
            '',
            'test_db',
            '3306'
        );
    }

    public function testConnectSuccess()
    {
        $mockPdo = $this->createMock(PDO::class);
        $this->dbConnection = $this->getMockBuilder(DataBaseConnection::class)
            ->setConstructorArgs(['localhost', 'root', '', 'test_db', '3306'])
            ->onlyMethods(['connect'])
            ->getMock();

        $this->dbConnection->expects($this->once())
            ->method('connect')
            ->willReturn($mockPdo);

        $connection = $this->dbConnection->connect();
        $this->assertInstanceOf(PDO::class, $connection);
    }

    public function testConnectFailure()
    {
        $this->dbConnection = $this->getMockBuilder(DataBaseConnection::class)
            ->setConstructorArgs(['localhost', 'wrong_user', 'wrong_pass', 'test_db', '3306'])
            ->onlyMethods(['connect'])
            ->getMock();

        $this->dbConnection->expects($this->once())
            ->method('connect')
            ->will($this->throwException(new Exception("Connection failed: Invalid credentials")));

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Connection failed: Invalid credentials");

        // This should throw an exception
        $this->dbConnection->connect();
    }
}

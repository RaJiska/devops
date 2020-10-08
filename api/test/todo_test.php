<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

include("../http/todo.php");


final class todo_test extends TestCase
{
	public function testValidName(): void
	{
		$this->assertEquals(
			true,
			isAValidname('toto')
		);
	}

	public function testInvalidName(): void
	{
		$this->assertEquals(
			false,
			isAValidname('toto@-)')
		);
	}
}
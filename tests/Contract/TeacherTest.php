<?php

declare(strict_types=1);

namespace Tourze\AQ8011\Tests\Contract;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tourze\AQ8011\Contract\Teacher;

/**
 * @internal
 */
#[CoversClass(Teacher::class)]
final class TeacherTest extends TestCase
{
    public function testInterfaceExists(): void
    {
        $this->assertTrue(interface_exists(Teacher::class));
    }

    public function testInterfaceCanBeImplemented(): void
    {
        $teacher = new class implements Teacher {};

        $this->assertInstanceOf(Teacher::class, $teacher);
    }

    public function testInterfaceIsInterface(): void
    {
        $reflection = new \ReflectionClass(Teacher::class);

        $this->assertTrue($reflection->isInterface());
        $this->assertFalse($reflection->isAbstract());
    }

    public function testInterfaceHasNoMethods(): void
    {
        $reflection = new \ReflectionClass(Teacher::class);

        $this->assertEmpty($reflection->getMethods());
    }

    public function testInterfaceHasNoProperties(): void
    {
        $reflection = new \ReflectionClass(Teacher::class);

        $this->assertEmpty($reflection->getProperties());
    }

    public function testInterfaceHasNoParentInterfaces(): void
    {
        $reflection = new \ReflectionClass(Teacher::class);

        $this->assertEmpty($reflection->getInterfaceNames());
    }

    public function testTypeCheckingWorks(): void
    {
        $teacher = new class implements Teacher {};

        $this->assertInstanceOf(Teacher::class, $teacher);
    }

    public function testInterfaceCanBeUsedAsTypeHint(): void
    {
        $implementation = new class implements Teacher {};

        $function = function (Teacher $teacher): bool {
            return true;
        };

        $this->assertTrue($function($implementation));
    }
}

<?php

declare(strict_types=1);

namespace Tourze\AQ8011\Tests\Contract;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tourze\AQ8011\Contract\FullTimeTeacher;
use Tourze\AQ8011\Contract\Teacher;

/**
 * @internal
 */
#[CoversClass(FullTimeTeacher::class)]
final class FullTimeTeacherTest extends TestCase
{
    public function testInterfaceExists(): void
    {
        $this->assertTrue(interface_exists(FullTimeTeacher::class));
    }

    public function testInterfaceExtendsTeacher(): void
    {
        $reflection = new \ReflectionClass(FullTimeTeacher::class);

        $this->assertTrue($reflection->implementsInterface(Teacher::class));
        $this->assertContains(Teacher::class, $reflection->getInterfaceNames());
    }

    public function testInterfaceCanBeImplemented(): void
    {
        $fullTimeTeacher = new class implements FullTimeTeacher {};

        $this->assertInstanceOf(FullTimeTeacher::class, $fullTimeTeacher);
        $this->assertInstanceOf(Teacher::class, $fullTimeTeacher);
    }

    public function testInterfaceIsInterface(): void
    {
        $reflection = new \ReflectionClass(FullTimeTeacher::class);

        $this->assertTrue($reflection->isInterface());
        $this->assertFalse($reflection->isAbstract());
    }

    public function testInterfaceHasNoMethods(): void
    {
        $reflection = new \ReflectionClass(FullTimeTeacher::class);

        $this->assertEmpty($reflection->getMethods());
    }

    public function testInterfaceHasNoProperties(): void
    {
        $reflection = new \ReflectionClass(FullTimeTeacher::class);

        $this->assertEmpty($reflection->getProperties());
    }

    public function testInheritanceHierarchy(): void
    {
        $reflection = new \ReflectionClass(FullTimeTeacher::class);
        $interfaces = $reflection->getInterfaceNames();

        $this->assertCount(1, $interfaces);
        $this->assertEquals(Teacher::class, $interfaces[0]);
    }

    public function testTypeCheckingWorks(): void
    {
        $fullTimeTeacher = new class implements FullTimeTeacher {};

        $this->assertInstanceOf(FullTimeTeacher::class, $fullTimeTeacher);
        $this->assertInstanceOf(Teacher::class, $fullTimeTeacher);
    }

    public function testInterfaceCanBeUsedAsTypeHint(): void
    {
        $implementation = new class implements FullTimeTeacher {};

        $functionForFullTime = function (FullTimeTeacher $teacher): bool {
            return true;
        };

        $functionForTeacher = function (Teacher $teacher): bool {
            return true;
        };

        $this->assertTrue($functionForFullTime($implementation));
        $this->assertTrue($functionForTeacher($implementation));
    }

    public function testPolymorphismWithTeacher(): void
    {
        $fullTimeTeacher = new class implements FullTimeTeacher {};

        // 多态：FullTimeTeacher 可以被当作 Teacher 使用
        $treatAsTeacher = function (Teacher $teacher): string {
            return get_class($teacher);
        };

        $result = $treatAsTeacher($fullTimeTeacher);
        // Result is guaranteed to be a non-empty class-string by the function signature
        $this->assertNotNull($result);
    }
}

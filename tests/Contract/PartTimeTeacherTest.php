<?php

declare(strict_types=1);

namespace Tourze\AQ8011\Tests\Contract;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tourze\AQ8011\Contract\PartTimeTeacher;
use Tourze\AQ8011\Contract\Teacher;

/**
 * @internal
 */
#[CoversClass(PartTimeTeacher::class)]
final class PartTimeTeacherTest extends TestCase
{
    public function testInterfaceExists(): void
    {
        $this->assertTrue(interface_exists(PartTimeTeacher::class));
    }

    public function testInterfaceExtendsTeacher(): void
    {
        $reflection = new \ReflectionClass(PartTimeTeacher::class);

        $this->assertTrue($reflection->implementsInterface(Teacher::class));
        $this->assertContains(Teacher::class, $reflection->getInterfaceNames());
    }

    public function testInterfaceCanBeImplemented(): void
    {
        $partTimeTeacher = new class implements PartTimeTeacher {};

        $this->assertInstanceOf(PartTimeTeacher::class, $partTimeTeacher);
        $this->assertInstanceOf(Teacher::class, $partTimeTeacher);
    }

    public function testInterfaceIsInterface(): void
    {
        $reflection = new \ReflectionClass(PartTimeTeacher::class);

        $this->assertTrue($reflection->isInterface());
        $this->assertFalse($reflection->isAbstract());
    }

    public function testInterfaceHasNoMethods(): void
    {
        $reflection = new \ReflectionClass(PartTimeTeacher::class);

        $this->assertEmpty($reflection->getMethods());
    }

    public function testInterfaceHasNoProperties(): void
    {
        $reflection = new \ReflectionClass(PartTimeTeacher::class);

        $this->assertEmpty($reflection->getProperties());
    }

    public function testInheritanceHierarchy(): void
    {
        $reflection = new \ReflectionClass(PartTimeTeacher::class);
        $interfaces = $reflection->getInterfaceNames();

        $this->assertCount(1, $interfaces);
        $this->assertEquals(Teacher::class, $interfaces[0]);
    }

    public function testTypeCheckingWorks(): void
    {
        $partTimeTeacher = new class implements PartTimeTeacher {};

        $this->assertInstanceOf(PartTimeTeacher::class, $partTimeTeacher);
        $this->assertInstanceOf(Teacher::class, $partTimeTeacher);
    }

    public function testInterfaceCanBeUsedAsTypeHint(): void
    {
        $implementation = new class implements PartTimeTeacher {};

        $functionForPartTime = function (PartTimeTeacher $teacher): bool {
            return true;
        };

        $functionForTeacher = function (Teacher $teacher): bool {
            return true;
        };

        $this->assertTrue($functionForPartTime($implementation));
        $this->assertTrue($functionForTeacher($implementation));
    }

    public function testPolymorphismWithTeacher(): void
    {
        $partTimeTeacher = new class implements PartTimeTeacher {};

        // 多态：PartTimeTeacher 可以被当作 Teacher 使用
        $treatAsTeacher = function (Teacher $teacher): string {
            return get_class($teacher);
        };

        $result = $treatAsTeacher($partTimeTeacher);
        // Result is guaranteed to be a non-empty class-string by the function signature
        $this->assertNotNull($result);
    }
}

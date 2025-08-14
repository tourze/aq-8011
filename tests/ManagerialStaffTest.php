<?php

namespace Tourze\AQ8011\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tourze\AQ8011\ManagerialStaff;
use Tourze\AQ8011\Teacher;

/**
 * @internal
 */
#[CoversClass(className: ManagerialStaff::class)]
final class ManagerialStaffTest extends TestCase
{
    public function testInterfaceExists(): void
    {
        $this->assertTrue(interface_exists(ManagerialStaff::class));
    }

    public function testInterfaceCanBeImplemented(): void
    {
        $managerialStaff = new class implements ManagerialStaff {};

        $this->assertInstanceOf(ManagerialStaff::class, $managerialStaff);
    }

    public function testInterfaceIsInterface(): void
    {
        $reflection = new \ReflectionClass(ManagerialStaff::class);

        $this->assertTrue($reflection->isInterface());
        $this->assertFalse($reflection->isAbstract());
    }

    public function testInterfaceHasNoMethods(): void
    {
        $reflection = new \ReflectionClass(ManagerialStaff::class);

        $this->assertEmpty($reflection->getMethods());
    }

    public function testInterfaceHasNoProperties(): void
    {
        $reflection = new \ReflectionClass(ManagerialStaff::class);

        $this->assertEmpty($reflection->getProperties());
    }

    public function testInterfaceHasNoParentInterfaces(): void
    {
        $reflection = new \ReflectionClass(ManagerialStaff::class);

        $this->assertEmpty($reflection->getInterfaceNames());
    }

    public function testInterfaceDoesNotExtendTeacher(): void
    {
        $reflection = new \ReflectionClass(ManagerialStaff::class);

        $this->assertFalse($reflection->implementsInterface(Teacher::class));
        $this->assertNotContains(Teacher::class, $reflection->getInterfaceNames());
    }

    public function testTypeCheckingWorks(): void
    {
        $managerialStaff = new class implements ManagerialStaff {};

        $this->assertInstanceOf(ManagerialStaff::class, $managerialStaff);

        // 使用反射来检查不实现 Teacher
        $reflection = new \ReflectionClass($managerialStaff);
        $this->assertFalse($reflection->implementsInterface(Teacher::class));
    }

    public function testInterfaceCanBeUsedAsTypeHint(): void
    {
        $implementation = new class implements ManagerialStaff {};

        $function = function (ManagerialStaff $staff): bool {
            return true;
        };

        $this->assertTrue($function($implementation));
    }

    public function testIndependenceFromTeacherHierarchy(): void
    {
        $managerialStaff = new class implements ManagerialStaff {};

        // ManagerialStaff 应该独立于 Teacher 层次结构
        $this->assertInstanceOf(ManagerialStaff::class, $managerialStaff);

        // 使用反射来检查不实现 Teacher
        $reflection = new \ReflectionClass($managerialStaff);
        $this->assertFalse($reflection->implementsInterface(Teacher::class));

        // 测试类型提示兼容性
        $staffFunction = function (ManagerialStaff $staff): string {
            return get_class($staff);
        };

        $result = $staffFunction($managerialStaff);
        // Result is guaranteed to be a non-empty class-string by the function signature
        $this->assertNotNull($result);
    }
}

<?php

namespace Tourze\AQ8011\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tourze\AQ8011\FullTimeTeacher;
use Tourze\AQ8011\ManagerialStaff;
use Tourze\AQ8011\PartTimeTeacher;
use Tourze\AQ8011\Teacher;

/**
 * @internal
 */
#[CoversClass(className: Teacher::class)]
final class InterfaceHierarchyTest extends TestCase
{
    public function testAllInterfacesExist(): void
    {
        $interfaces = [
            Teacher::class,
            FullTimeTeacher::class,
            PartTimeTeacher::class,
            ManagerialStaff::class,
        ];

        foreach ($interfaces as $interface) {
            $this->assertTrue(
                interface_exists($interface),
                "Interface {$interface} should exist"
            );
        }
    }

    public function testTeacherInheritanceHierarchy(): void
    {
        // Teacher 是基础接口
        $teacherReflection = new \ReflectionClass(Teacher::class);
        $this->assertEmpty($teacherReflection->getInterfaceNames());

        // FullTimeTeacher 继承 Teacher
        $fullTimeReflection = new \ReflectionClass(FullTimeTeacher::class);
        $this->assertTrue($fullTimeReflection->implementsInterface(Teacher::class));
        $this->assertContains(Teacher::class, $fullTimeReflection->getInterfaceNames());

        // PartTimeTeacher 继承 Teacher
        $partTimeReflection = new \ReflectionClass(PartTimeTeacher::class);
        $this->assertTrue($partTimeReflection->implementsInterface(Teacher::class));
        $this->assertContains(Teacher::class, $partTimeReflection->getInterfaceNames());

        // ManagerialStaff 独立，不继承 Teacher
        $managerialReflection = new \ReflectionClass(ManagerialStaff::class);
        $this->assertFalse($managerialReflection->implementsInterface(Teacher::class));
        $this->assertNotContains(Teacher::class, $managerialReflection->getInterfaceNames());
    }

    public function testInterfaceImplementationsWorkCorrectly(): void
    {
        // 创建实现类
        $teacher = new class implements Teacher {};
        $fullTimeTeacher = new class implements FullTimeTeacher {};
        $partTimeTeacher = new class implements PartTimeTeacher {};
        $managerialStaff = new class implements ManagerialStaff {};

        // 验证基本类型
        $this->assertInstanceOf(Teacher::class, $teacher);
        $this->assertInstanceOf(FullTimeTeacher::class, $fullTimeTeacher);
        $this->assertInstanceOf(PartTimeTeacher::class, $partTimeTeacher);
        $this->assertInstanceOf(ManagerialStaff::class, $managerialStaff);

        // 验证继承关系
        $this->assertInstanceOf(Teacher::class, $fullTimeTeacher);
        $this->assertInstanceOf(Teacher::class, $partTimeTeacher);

        // 使用反射来验证 ManagerialStaff 不实现 Teacher
        $reflection = new \ReflectionClass($managerialStaff);
        $this->assertFalse($reflection->implementsInterface(Teacher::class));
    }

    public function testPolymorphismWorks(): void
    {
        $fullTimeTeacher = new class implements FullTimeTeacher {};
        $partTimeTeacher = new class implements PartTimeTeacher {};

        // 多态：两种教师都可以被当作 Teacher 使用
        $teachers = [$fullTimeTeacher, $partTimeTeacher];

        foreach ($teachers as $teacher) {
            $this->assertInstanceOf(Teacher::class, $teacher);

            $teacherFunction = function (Teacher $t): bool {
                return true;
            };

            $this->assertTrue($teacherFunction($teacher));
        }
    }

    public function testTypeSeparation(): void
    {
        // 使用反射来检查类型分离
        $fullTimeReflection = new \ReflectionClass(FullTimeTeacher::class);
        $partTimeReflection = new \ReflectionClass(PartTimeTeacher::class);
        $managerialReflection = new \ReflectionClass(ManagerialStaff::class);

        // FullTimeTeacher 和 PartTimeTeacher 应该是不同的接口
        $this->assertNotEquals($fullTimeReflection->getName(), $partTimeReflection->getName());

        // ManagerialStaff 应该与所有教师类型分离
        $this->assertFalse($managerialReflection->implementsInterface(Teacher::class));
        $this->assertFalse($managerialReflection->implementsInterface(FullTimeTeacher::class));
        $this->assertFalse($managerialReflection->implementsInterface(PartTimeTeacher::class));
    }

    public function testInterfaceNamespaceConsistency(): void
    {
        $expectedNamespace = 'Tourze\AQ8011';

        $interfaces = [
            Teacher::class,
            FullTimeTeacher::class,
            PartTimeTeacher::class,
            ManagerialStaff::class,
        ];

        foreach ($interfaces as $interface) {
            $reflection = new \ReflectionClass($interface);
            $this->assertEquals(
                $expectedNamespace,
                $reflection->getNamespaceName(),
                "Interface {$interface} should be in namespace {$expectedNamespace}"
            );
        }
    }

    public function testAllInterfacesAreEmpty(): void
    {
        $interfaces = [
            Teacher::class,
            FullTimeTeacher::class,
            PartTimeTeacher::class,
            ManagerialStaff::class,
        ];

        foreach ($interfaces as $interface) {
            $reflection = new \ReflectionClass($interface);

            $this->assertEmpty(
                $reflection->getMethods(),
                "Interface {$interface} should have no methods"
            );

            $this->assertEmpty(
                $reflection->getProperties(),
                "Interface {$interface} should have no properties"
            );
        }
    }

    public function testComplexImplementationScenarios(): void
    {
        // 测试一个类同时实现多个不相关的接口
        $multiRoleStaff = new class implements FullTimeTeacher, ManagerialStaff {};

        $this->assertInstanceOf(FullTimeTeacher::class, $multiRoleStaff);
        $this->assertInstanceOf(Teacher::class, $multiRoleStaff);
        $this->assertInstanceOf(ManagerialStaff::class, $multiRoleStaff);

        // 验证类型提示的灵活性
        $teacherFunction = function (Teacher $t): string { return 'teacher'; };
        $staffFunction = function (ManagerialStaff $s): string { return 'staff'; };

        $this->assertEquals('teacher', $teacherFunction($multiRoleStaff));
        $this->assertEquals('staff', $staffFunction($multiRoleStaff));
    }
}

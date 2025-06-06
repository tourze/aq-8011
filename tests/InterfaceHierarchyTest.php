<?php

namespace Tourze\AQ8011\Tests;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Tourze\AQ8011\FullTimeTeacher;
use Tourze\AQ8011\ManagerialStaff;
use Tourze\AQ8011\PartTimeTeacher;
use Tourze\AQ8011\Teacher;

class InterfaceHierarchyTest extends TestCase
{
    public function test_all_interfaces_exist(): void
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

    public function test_teacher_inheritance_hierarchy(): void
    {
        // Teacher 是基础接口
        $teacherReflection = new ReflectionClass(Teacher::class);
        $this->assertEmpty($teacherReflection->getInterfaceNames());

        // FullTimeTeacher 继承 Teacher
        $fullTimeReflection = new ReflectionClass(FullTimeTeacher::class);
        $this->assertTrue($fullTimeReflection->implementsInterface(Teacher::class));
        $this->assertContains(Teacher::class, $fullTimeReflection->getInterfaceNames());

        // PartTimeTeacher 继承 Teacher
        $partTimeReflection = new ReflectionClass(PartTimeTeacher::class);
        $this->assertTrue($partTimeReflection->implementsInterface(Teacher::class));
        $this->assertContains(Teacher::class, $partTimeReflection->getInterfaceNames());

        // ManagerialStaff 独立，不继承 Teacher
        $managerialReflection = new ReflectionClass(ManagerialStaff::class);
        $this->assertFalse($managerialReflection->implementsInterface(Teacher::class));
        $this->assertNotContains(Teacher::class, $managerialReflection->getInterfaceNames());
    }

    public function test_interface_implementations_work_correctly(): void
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
        $this->assertNotInstanceOf(Teacher::class, $managerialStaff);
    }

    public function test_polymorphism_works(): void
    {
        $fullTimeTeacher = new class implements FullTimeTeacher {};
        $partTimeTeacher = new class implements PartTimeTeacher {};

        // 多态：两种教师都可以被当作 Teacher 使用
        $teachers = [$fullTimeTeacher, $partTimeTeacher];

        foreach ($teachers as $teacher) {
            $this->assertInstanceOf(Teacher::class, $teacher);
            
            $teacherFunction = function (Teacher $t): bool {
                return $t instanceof Teacher;
            };
            
            $this->assertTrue($teacherFunction($teacher));
        }
    }

    public function test_type_separation(): void
    {
        $fullTimeTeacher = new class implements FullTimeTeacher {};
        $partTimeTeacher = new class implements PartTimeTeacher {};
        $managerialStaff = new class implements ManagerialStaff {};

        // FullTimeTeacher 和 PartTimeTeacher 应该是不同的类型
        $this->assertNotInstanceOf(PartTimeTeacher::class, $fullTimeTeacher);
        $this->assertNotInstanceOf(FullTimeTeacher::class, $partTimeTeacher);

        // ManagerialStaff 应该与所有教师类型分离
        $this->assertNotInstanceOf(Teacher::class, $managerialStaff);
        $this->assertNotInstanceOf(FullTimeTeacher::class, $managerialStaff);
        $this->assertNotInstanceOf(PartTimeTeacher::class, $managerialStaff);
    }

    public function test_interface_namespace_consistency(): void
    {
        $expectedNamespace = 'Tourze\\AQ8011';
        
        $interfaces = [
            Teacher::class,
            FullTimeTeacher::class,
            PartTimeTeacher::class,
            ManagerialStaff::class,
        ];

        foreach ($interfaces as $interface) {
            $reflection = new ReflectionClass($interface);
            $this->assertEquals(
                $expectedNamespace,
                $reflection->getNamespaceName(),
                "Interface {$interface} should be in namespace {$expectedNamespace}"
            );
        }
    }

    public function test_all_interfaces_are_empty(): void
    {
        $interfaces = [
            Teacher::class,
            FullTimeTeacher::class,
            PartTimeTeacher::class,
            ManagerialStaff::class,
        ];

        foreach ($interfaces as $interface) {
            $reflection = new ReflectionClass($interface);
            
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

    public function test_complex_implementation_scenarios(): void
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
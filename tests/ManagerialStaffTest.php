<?php

namespace Tourze\AQ8011\Tests;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Tourze\AQ8011\ManagerialStaff;
use Tourze\AQ8011\Teacher;

class ManagerialStaffTest extends TestCase
{
    public function test_interface_exists(): void
    {
        $this->assertTrue(interface_exists(ManagerialStaff::class));
    }

    public function test_interface_can_be_implemented(): void
    {
        $managerialStaff = new class implements ManagerialStaff {};
        
        $this->assertInstanceOf(ManagerialStaff::class, $managerialStaff);
    }

    public function test_interface_is_interface(): void
    {
        $reflection = new ReflectionClass(ManagerialStaff::class);
        
        $this->assertTrue($reflection->isInterface());
        $this->assertFalse($reflection->isAbstract());
    }

    public function test_interface_has_no_methods(): void
    {
        $reflection = new ReflectionClass(ManagerialStaff::class);
        
        $this->assertEmpty($reflection->getMethods());
    }

    public function test_interface_has_no_properties(): void
    {
        $reflection = new ReflectionClass(ManagerialStaff::class);
        
        $this->assertEmpty($reflection->getProperties());
    }

    public function test_interface_has_no_parent_interfaces(): void
    {
        $reflection = new ReflectionClass(ManagerialStaff::class);
        
        $this->assertEmpty($reflection->getInterfaceNames());
    }

    public function test_interface_does_not_extend_teacher(): void
    {
        $reflection = new ReflectionClass(ManagerialStaff::class);
        
        $this->assertFalse($reflection->implementsInterface(Teacher::class));
        $this->assertNotContains(Teacher::class, $reflection->getInterfaceNames());
    }

    public function test_type_checking_works(): void
    {
        $managerialStaff = new class implements ManagerialStaff {};
        
        $this->assertTrue($managerialStaff instanceof ManagerialStaff);
        $this->assertInstanceOf(ManagerialStaff::class, $managerialStaff);
        
        // 确保不是 Teacher 类型
        $this->assertFalse($managerialStaff instanceof Teacher);
        $this->assertNotInstanceOf(Teacher::class, $managerialStaff);
    }

    public function test_interface_can_be_used_as_type_hint(): void
    {
        $implementation = new class implements ManagerialStaff {};
        
        $function = function (ManagerialStaff $staff): bool {
            return $staff instanceof ManagerialStaff;
        };
        
        $this->assertTrue($function($implementation));
    }

    public function test_independence_from_teacher_hierarchy(): void
    {
        $managerialStaff = new class implements ManagerialStaff {};
        
        // ManagerialStaff 应该独立于 Teacher 层次结构
        $this->assertInstanceOf(ManagerialStaff::class, $managerialStaff);
        $this->assertNotInstanceOf(Teacher::class, $managerialStaff);
        
        // 测试类型提示兼容性
        $staffFunction = function (ManagerialStaff $staff): string {
            return get_class($staff);
        };
        
        $result = $staffFunction($managerialStaff);
        $this->assertIsString($result);
    }
} 
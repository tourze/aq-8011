<?php

namespace Tourze\AQ8011\Tests;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Tourze\AQ8011\PartTimeTeacher;
use Tourze\AQ8011\Teacher;

class PartTimeTeacherTest extends TestCase
{
    public function test_interface_exists(): void
    {
        $this->assertTrue(interface_exists(PartTimeTeacher::class));
    }

    public function test_interface_extends_teacher(): void
    {
        $reflection = new ReflectionClass(PartTimeTeacher::class);
        
        $this->assertTrue($reflection->implementsInterface(Teacher::class));
        $this->assertContains(Teacher::class, $reflection->getInterfaceNames());
    }

    public function test_interface_can_be_implemented(): void
    {
        $partTimeTeacher = new class implements PartTimeTeacher {};
        
        $this->assertInstanceOf(PartTimeTeacher::class, $partTimeTeacher);
        $this->assertInstanceOf(Teacher::class, $partTimeTeacher);
    }

    public function test_interface_is_interface(): void
    {
        $reflection = new ReflectionClass(PartTimeTeacher::class);
        
        $this->assertTrue($reflection->isInterface());
        $this->assertFalse($reflection->isAbstract());
    }

    public function test_interface_has_no_methods(): void
    {
        $reflection = new ReflectionClass(PartTimeTeacher::class);
        
        $this->assertEmpty($reflection->getMethods());
    }

    public function test_interface_has_no_properties(): void
    {
        $reflection = new ReflectionClass(PartTimeTeacher::class);
        
        $this->assertEmpty($reflection->getProperties());
    }

    public function test_inheritance_hierarchy(): void
    {
        $reflection = new ReflectionClass(PartTimeTeacher::class);
        $interfaces = $reflection->getInterfaceNames();
        
        $this->assertCount(1, $interfaces);
        $this->assertEquals(Teacher::class, $interfaces[0]);
    }

    public function test_type_checking_works(): void
    {
        $partTimeTeacher = new class implements PartTimeTeacher {};
        
        $this->assertInstanceOf(PartTimeTeacher::class, $partTimeTeacher);
        $this->assertInstanceOf(Teacher::class, $partTimeTeacher);
    }

    public function test_interface_can_be_used_as_type_hint(): void
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

    public function test_polymorphism_with_teacher(): void
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
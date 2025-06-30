<?php

namespace Tourze\AQ8011\Tests;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Tourze\AQ8011\FullTimeTeacher;
use Tourze\AQ8011\Teacher;

class FullTimeTeacherTest extends TestCase
{
    public function test_interface_exists(): void
    {
        $this->assertTrue(interface_exists(FullTimeTeacher::class));
    }

    public function test_interface_extends_teacher(): void
    {
        $reflection = new ReflectionClass(FullTimeTeacher::class);
        
        $this->assertTrue($reflection->implementsInterface(Teacher::class));
        $this->assertContains(Teacher::class, $reflection->getInterfaceNames());
    }

    public function test_interface_can_be_implemented(): void
    {
        $fullTimeTeacher = new class implements FullTimeTeacher {};
        
        $this->assertInstanceOf(FullTimeTeacher::class, $fullTimeTeacher);
        $this->assertInstanceOf(Teacher::class, $fullTimeTeacher);
    }

    public function test_interface_is_interface(): void
    {
        $reflection = new ReflectionClass(FullTimeTeacher::class);
        
        $this->assertTrue($reflection->isInterface());
        $this->assertFalse($reflection->isAbstract());
    }

    public function test_interface_has_no_methods(): void
    {
        $reflection = new ReflectionClass(FullTimeTeacher::class);
        
        $this->assertEmpty($reflection->getMethods());
    }

    public function test_interface_has_no_properties(): void
    {
        $reflection = new ReflectionClass(FullTimeTeacher::class);
        
        $this->assertEmpty($reflection->getProperties());
    }

    public function test_inheritance_hierarchy(): void
    {
        $reflection = new ReflectionClass(FullTimeTeacher::class);
        $interfaces = $reflection->getInterfaceNames();
        
        $this->assertCount(1, $interfaces);
        $this->assertEquals(Teacher::class, $interfaces[0]);
    }

    public function test_type_checking_works(): void
    {
        $fullTimeTeacher = new class implements FullTimeTeacher {};
        
        $this->assertInstanceOf(FullTimeTeacher::class, $fullTimeTeacher);
        $this->assertInstanceOf(Teacher::class, $fullTimeTeacher);
    }

    public function test_interface_can_be_used_as_type_hint(): void
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

    public function test_polymorphism_with_teacher(): void
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
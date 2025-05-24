<?php

namespace Tourze\AQ8011\Tests;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Tourze\AQ8011\Teacher;

class TeacherTest extends TestCase
{
    public function test_interface_exists(): void
    {
        $this->assertTrue(interface_exists(Teacher::class));
    }

    public function test_interface_can_be_implemented(): void
    {
        $teacher = new class implements Teacher {};
        
        $this->assertInstanceOf(Teacher::class, $teacher);
    }

    public function test_interface_is_interface(): void
    {
        $reflection = new ReflectionClass(Teacher::class);
        
        $this->assertTrue($reflection->isInterface());
        $this->assertFalse($reflection->isAbstract());
    }

    public function test_interface_has_no_methods(): void
    {
        $reflection = new ReflectionClass(Teacher::class);
        
        $this->assertEmpty($reflection->getMethods());
    }

    public function test_interface_has_no_properties(): void
    {
        $reflection = new ReflectionClass(Teacher::class);
        
        $this->assertEmpty($reflection->getProperties());
    }

    public function test_interface_has_no_parent_interfaces(): void
    {
        $reflection = new ReflectionClass(Teacher::class);
        
        $this->assertEmpty($reflection->getInterfaceNames());
    }

    public function test_type_checking_works(): void
    {
        $teacher = new class implements Teacher {};
        
        $this->assertTrue($teacher instanceof Teacher);
        $this->assertInstanceOf(Teacher::class, $teacher);
    }

    public function test_interface_can_be_used_as_type_hint(): void
    {
        $implementation = new class implements Teacher {};
        
        $function = function (Teacher $teacher): bool {
            return $teacher instanceof Teacher;
        };
        
        $this->assertTrue($function($implementation));
    }
} 
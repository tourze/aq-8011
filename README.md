# AQ 8011-2023

[English](README.md) | [中文](README.zh-CN.md)

[![Latest Version](https://img.shields.io/packagist/v/tourze/aq-8011.svg?style=flat-square)](https://packagist.org/packages/tourze/aq-8011)
[![Total Downloads](https://img.shields.io/packagist/dt/tourze/aq-8011.svg?style=flat-square)](https://packagist.org/packages/tourze/aq-8011)
[![PHP Version](https://img.shields.io/packagist/php-v/tourze/aq-8011.svg?style=flat-square)](https://packagist.org/packages/tourze/aq-8011)
[![License](https://img.shields.io/packagist/l/tourze/aq-8011.svg?style=flat-square)](https://packagist.org/packages/tourze/aq-8011)

符合 AQ 8011-2023 标准的安全生产培训机构人员接口定义包。

## 描述

此包实现了 AQ 8011-2023《安全生产培训机构基本条件》标准中定义的培训机构人员类型接口，包括教师和管理人员的分类定义。

## 安装

```bash
composer require tourze/aq-8011
```

## 接口定义

### Teacher（教师）

基础教师接口，所有教师类型的父接口。

```php
use Tourze\AQ8011\Teacher;

class MyTeacher implements Teacher
{
    // 实现教师相关逻辑
}
```

### FullTimeTeacher（专职教师）

专职教师接口，继承自 `Teacher`。

**定义**：与安全生产培训机构签订劳动合同或事业单位聘用合同，专门从事安全生产培训教学工作，具备安全生产培训类别应有的专业知识、技能和教学能力的人员。

```php
use Tourze\AQ8011\FullTimeTeacher;

class MyFullTimeTeacher implements FullTimeTeacher
{
    // 专职教师实现
}
```

### PartTimeTeacher（兼职教师）

兼职教师接口，继承自 `Teacher`。

**定义**：由安全生产培训机构聘请，兼职从事安全生产培训教学工作，具备安全生产培训类别应有的专业知识、技能和教学能力的人员。

```php
use Tourze\AQ8011\PartTimeTeacher;

class MyPartTimeTeacher implements PartTimeTeacher
{
    // 兼职教师实现
}
```

### ManagerialStaff（管理人员）

管理人员接口，独立于教师层次结构。

**定义**：与安全生产培训机构签订劳动合同或事业单位聘用合同，承担安全生产培训教学管理、线上安全生产培训平台管理及服务工作任务的人员。

```php
use Tourze\AQ8011\ManagerialStaff;

class MyManagerialStaff implements ManagerialStaff
{
    // 管理人员实现
}
```

## 使用示例

### 基本使用

```php
use Tourze\AQ8011\FullTimeTeacher;
use Tourze\AQ8011\PartTimeTeacher;
use Tourze\AQ8011\ManagerialStaff;

// 专职教师实现
class SafetyTrainingFullTimeTeacher implements FullTimeTeacher
{
    public function conductTraining(): void
    {
        // 实施专职培训
    }
}

// 兼职教师实现
class ExpertPartTimeTeacher implements PartTimeTeacher
{
    public function providExpertise(): void
    {
        // 提供专业指导
    }
}

// 管理人员实现
class TrainingManager implements ManagerialStaff
{
    public function manageTrainingPrograms(): void
    {
        // 管理培训项目
    }
}
```

### 多态使用

```php
use Tourze\AQ8011\Teacher;

function assignTeachingTask(Teacher $teacher): void
{
    // 可以接受任何类型的教师
    echo "分配教学任务给: " . get_class($teacher);
}

$fullTimeTeacher = new SafetyTrainingFullTimeTeacher();
$partTimeTeacher = new ExpertPartTimeTeacher();

assignTeachingTask($fullTimeTeacher); // 正常工作
assignTeachingTask($partTimeTeacher); // 正常工作
```

### 混合角色

```php
// 一个人可以同时担任多个角色
class MultiRoleStaff implements FullTimeTeacher, ManagerialStaff
{
    public function teach(): void
    {
        // 教学功能
    }
    
    public function manage(): void
    {
        // 管理功能
    }
}
```

## 接口层次结构

```
Teacher (教师基础接口)
├── FullTimeTeacher (专职教师)
└── PartTimeTeacher (兼职教师)

ManagerialStaff (管理人员，独立接口)
```

## 开发

### 运行测试

```bash
# 在项目根目录运行
./vendor/bin/phpunit packages/aq-8011/tests
```

### 代码风格检查

```bash
./vendor/bin/phpstan analyse packages/aq-8011/src -l 1
```

## 许可证

MIT

## 参考文档

- AQ 8011-2023《安全生产培训机构基本条件》

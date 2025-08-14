# AQ 8011-2023

[English](README.md) | [中文](README.zh-CN.md)

[![Latest Version](https://img.shields.io/packagist/v/tourze/aq-8011.svg?style=flat-square)](https://packagist.org/packages/tourze/aq-8011)
[![Total Downloads](https://img.shields.io/packagist/dt/tourze/aq-8011.svg?style=flat-square)](https://packagist.org/packages/tourze/aq-8011)
[![PHP Version](https://img.shields.io/packagist/php-v/tourze/aq-8011.svg?style=flat-square)](https://packagist.org/packages/tourze/aq-8011)
[![License](https://img.shields.io/packagist/l/tourze/aq-8011.svg?style=flat-square)](https://packagist.org/packages/tourze/aq-8011)

符合 AQ 8011-2023 标准的安全生产培训机构人员接口定义包。

## 简介

本包依据 AQ 8011-2023《安全生产培训机构基本条件》国家标准，提供了安全生产培训机构人员分类的 PHP 接口定义，包含教师和管理人员的标准化类型约束。

## Installation

使用 Composer 安装此包：

```bash
composer require tourze/aq-8011
```

### 系统要求

- PHP 8.1 或更高版本
- Composer 2.x

## Quick Start

### 基本使用示例

```php
<?php

use Tourze\AQ8011\FullTimeTeacher;
use Tourze\AQ8011\PartTimeTeacher;
use Tourze\AQ8011\ManagerialStaff;

// 实现专职教师
class SafetyTrainingFullTimeTeacher implements FullTimeTeacher
{
    public function getName(): string
    {
        return '专职安全培训教师';
    }
}

// 实现兼职教师
class ExpertPartTimeTeacher implements PartTimeTeacher
{
    public function getName(): string
    {
        return '兼职专家教师';
    }
}

// 实现管理人员
class TrainingManager implements ManagerialStaff
{
    public function getName(): string
    {
        return '培训管理员';
    }
}

// 使用示例
$fullTimeTeacher = new SafetyTrainingFullTimeTeacher();
$partTimeTeacher = new ExpertPartTimeTeacher();
$manager = new TrainingManager();

// 类型检查
if ($fullTimeTeacher instanceof FullTimeTeacher) {
    echo "这是专职教师\n";
}

if ($partTimeTeacher instanceof PartTimeTeacher) {
    echo "这是兼职教师\n";
}

if ($manager instanceof ManagerialStaff) {
    echo "这是管理人员\n";
}
```

## 标准依据

AQ 8011-2023《安全生产培训机构基本条件》是国家应急管理部发布的行业标准，规定了安全生产培训机构的基本条件要求，包括人员配置、设施设备、管理制度等方面。

## 人员分类

### 教师类别

#### 1. 专职教师 (FullTimeTeacher)

- **定义**：与安全生产培训机构签订劳动合同或事业单位聘用合同，专门从事安全生产培训教学工作，具备安全生产培训类别应有的专业知识、技能和教学能力的人员。
- **特点**：全职从事教学工作，具有稳定的雇佣关系

#### 2. 兼职教师 (PartTimeTeacher)  

- **定义**：由安全生产培训机构聘请，兼职从事安全生产培训教学工作，具备安全生产培训类别应有的专业知识、技能和教学能力的人员。
- **特点**：非全职教学，通常为外聘专家或兼职人员

### 管理人员 (ManagerialStaff)

- **定义**：与安全生产培训机构签订劳动合同或事业单位聘用合同，承担安全生产培训教学管理、线上安全生产培训平台管理及服务工作任务的人员。
- **特点**：负责培训管理和平台运营，不直接从事教学

## 技术实现

### 接口设计原则

1. **类型安全**：通过接口约束确保人员分类的准确性
2. **继承层次**：教师类型继承基础 Teacher 接口，体现分类关系
3. **职责分离**：管理人员独立于教师层次，体现不同职能
4. **扩展性**：空接口设计便于后续功能扩展

### 类型关系图

```
Tourze\AQ8011\Teacher
    ├── Tourze\AQ8011\FullTimeTeacher
    └── Tourze\AQ8011\PartTimeTeacher

Tourze\AQ8011\ManagerialStaff (独立接口)
```

## 应用场景

### 培训机构人员管理系统

```php
// 人员分类统计
function getStaffStatistics(array $staffList): array
{
    $stats = [
        'full_time_teachers' => 0,
        'part_time_teachers' => 0,
        'managerial_staff' => 0,
    ];
    
    foreach ($staffList as $staff) {
        if ($staff instanceof FullTimeTeacher) {
            $stats['full_time_teachers']++;
        } elseif ($staff instanceof PartTimeTeacher) {
            $stats['part_time_teachers']++;
        } elseif ($staff instanceof ManagerialStaff) {
            $stats['managerial_staff']++;
        }
    }
    
    return $stats;
}
```

### 培训任务分配

```php
// 根据人员类型分配不同的培训任务
function assignTrainingTasks(Teacher $teacher, string $taskType): void
{
    if ($teacher instanceof FullTimeTeacher) {
        // 专职教师可承担核心课程
        assignCoreTrainingTask($teacher, $taskType);
    } elseif ($teacher instanceof PartTimeTeacher) {
        // 兼职教师承担专业课程
        assignSpecializedTrainingTask($teacher, $taskType);
    }
}
```

### 合规性检查

```php
// 检查培训机构人员配置是否符合标准要求
function validateInstitutionCompliance(array $staffList): bool
{
    $fullTimeTeachers = array_filter($staffList, fn($staff) => $staff instanceof FullTimeTeacher);
    $managerialStaff = array_filter($staffList, fn($staff) => $staff instanceof ManagerialStaff);
    
    // 根据 AQ 8011-2023 标准要求进行验证
    return count($fullTimeTeachers) >= 3 && count($managerialStaff) >= 1;
}
```

## 质量保证

### 测试覆盖

- ✅ 接口存在性测试
- ✅ 继承关系验证
- ✅ 类型约束测试
- ✅ 多态行为验证
- ✅ 边界条件测试
- ✅ 复杂场景测试

### 代码质量

- ✅ PHPStan 静态分析通过
- ✅ PSR-12 代码风格规范
- ✅ 100% 测试覆盖率
- ✅ 零依赖设计

## 版本兼容性

- PHP 8.1+
- 兼容 Composer 2.x
- 支持 PSR-4 自动加载

## 贡献指南

1. Fork 本项目
2. 创建功能分支
3. 提交变更
4. 发起 Pull Request

## 许可证

MIT License - 详见 [LICENSE](LICENSE) 文件

## 相关资源

- [AQ 8011-2023 标准文档](https://www.mem.gov.cn/)
- [应急管理部官网](https://www.mem.gov.cn/)
- [安全生产培训相关法规](https://www.mem.gov.cn/)

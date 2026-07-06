<?php

namespace App\Enums;

enum SalaryType: string
{
    case Hourly = 'hourly';
    case Salary = 'salary';
    case Contract = 'contract';
}

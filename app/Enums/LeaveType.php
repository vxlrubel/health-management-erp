<?php

namespace App\Enums;

enum LeaveType: string
{
    case Annual = 'annual';
    case Sick = 'sick';
    case Personal = 'personal';
    case Maternity = 'maternity';
    case Paternity = 'paternity';
    case Bereavement = 'bereavement';
    case Other = 'other';
}

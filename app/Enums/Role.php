<?php

namespace App\Enums;

enum Role: string
{
    case ADMIN = 'admin';
    case IT_MANAGER = 'it-manager';
    case TECHNICIAN = 'technician';
    case USER = 'user';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'ผู้ดูแลระบบ',
            self::IT_MANAGER => 'ผู้จัดการไอที',
            self::TECHNICIAN => 'ช่างเทคนิค',
            self::USER => 'ผู้ใช้งานทั่วไป',
        };
    }
}
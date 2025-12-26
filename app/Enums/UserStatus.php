<?php

namespace App\Enums;

enum UserStatus: string
{
    case ACTIVE = 'active';
    case DORMANT = 'dormant';
    case SUSPENDED = 'suspended';
    case BANNED = 'banned';

    public function label(): string
    {
        return match($this) {
            self::ACTIVE => 'نشط',
            self::DORMANT => 'مهمل',
            self::SUSPENDED => 'معلق',
            self::BANNED => 'محظور',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::ACTIVE => 'emerald',
            self::DORMANT => 'slate',
            self::SUSPENDED => 'amber',
            self::BANNED => 'red',
        };
    }

    // الأيقونات الجديدة لكل حالة
    public function icon(): string
    {
        return match($this) {
            self::ACTIVE => 'fa-user-check',      // أيقونة النشط
            self::DORMANT => 'fa-user-clock',     // أيقونة المهمل (ساعة توحي بالغياب)
            self::SUSPENDED => 'fa-user-lock',    // أيقونة المعلق (قفل يوحي بالتقييد)
            self::BANNED => 'fa-user-xmark',      // أيقونة المحظور (إكس يوحي بالمنع)
        };
    }
}
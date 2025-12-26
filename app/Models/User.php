<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use App\Enums\UserStatus;
use Laravel\Fortify\TwoFactorAuthenticatable;


class User extends Authenticatable implements MustVerifyEmail, FilamentUser // أضف FilamentUser هنا
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
protected $fillable = [
    'name',
    'username',
    'email',
    'password',
    'avatar',
    // --- أضف هذه الحقول ---
    'bio',
    'company',
    'location',
    'website',
    'social_twitter',
    'social_linkedin',
    'notify_updates',
    'notify_repo_activity',
    'notify_stars',
    'google_id',     // <--- أضف هذا
        'google_token',  // <--- أضف هذا
        'is_admin',
        'otp',
    'otp_expires_at',
];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => UserStatus::class,
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean', // <--- أضف هذا السطر هنا
        ];
    }

    public function generateOtp(): string
{
    $otp = (string) rand(100000, 999999);

    $this->update([
        'otp' => $otp,
        'otp_expires_at' => now()->addMinutes(15), // صلاحية الكود 15 دقيقة
    ]);

    return $otp;
}

/**
 * التحقق من صحة الرمز
 */
public function verifyOtp(string $code): bool
{
    if ($this->otp === $code && now()->lessThan($this->otp_expires_at)) {
        $this->update([
            'otp' => null,
            'otp_expires_at' => null,
            'email_verified_at' => now(),
        ]);
        return true;
    }

    return false;
}
public function canAccessPanel(Panel $panel): bool
    {
        // الوصول مسموح فقط لمن لديه قيمة true في حقل is_admin
        return $this->is_admin === true; 
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }
    
      public function models()
    {
        return $this->hasMany(AiModel::class);
    }

        public function datasets(): HasMany
    {
        return $this->hasMany(Dataset::class);
    }

    public function joinedProjects()
    {
        return $this->belongsToMany(Project::class, 'project_user')
            ->withPivot('role')
            ->withTimestamps();
    }

        public function aiModels()
    {
        return $this->hasMany(AiModel::class);
    }

    public function tickets()
{
    return $this->hasMany(Ticket::class);
}
public function getAvatarUrlAttribute()
    {
        // 1. إذا لم توجد صورة، نرجع صورة افتراضية
        if (!$this->avatar) {
            return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
        }

        // 2. إذا كان الرابط خارجياً (مثل جوجل)، نرجعه كما هو
        if (filter_var($this->avatar, FILTER_VALIDATE_URL)) {
            return $this->avatar;
        }

        // 3. (مهم جداً) إجبار النظام على جلب الرابط من الديسك المحلي public
        // بدلاً من wasabi
        return \Illuminate\Support\Facades\Storage::disk('public')->url($this->avatar);
    }
    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url;
    }

// 1. المتابعون لي (الناس اللي تتابعني)
    public function followers()
    {
        // الجدول: followers
        // المفتاح الخاص بي في الجدول: following_id (لأني أنا المتابَع)
        // مفتاح الشخص الآخر: follower_id (هو المتابع)
        return $this->belongsToMany(User::class, 'followers', 'following_id', 'follower_id')->withTimestamps();
    }

    // 2. الأشخاص الذين أتابعهم (اللي أنا مسوي لهم فولو)
    public function followings()
    {
        // المفتاح الخاص بي: follower_id (لأني أنا المتابع)
        // مفتاح الشخص الآخر: following_id (هو المتابَع)
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'following_id')->withTimestamps();
    }

    // 3. دالة مساعدة للتحقق: هل أنا أتابع هذا الشخص؟
    public function isFollowing(User $user)
    {
        return $this->followings()->where('following_id', $user->id)->exists();
    }

public function contributions()
    {
        return $this->hasMany(Contribution::class);
    }

public function isOnline()
    {
        return \Illuminate\Support\Facades\DB::table('sessions')
            ->where('user_id', $this->id)
            ->where('last_activity', '>', now()->subMinutes(5)->getTimestamp())
            ->exists();
    }

    /**
     * جلب وقت آخر ظهور للمستخدم
     */
    public function getLastSeenAttribute()
    {
        $lastActivity = \Illuminate\Support\Facades\DB::table('sessions')
            ->where('user_id', $this->id)
            ->latest('last_activity')
            ->value('last_activity');

        return $lastActivity ? \Carbon\Carbon::createFromTimestamp($lastActivity) : null;
    }

    public function getContributionMapProperty()
{
    // جلب المساهمات لآخر 365 يوم وتجميعها حسب التاريخ
    $contributions = $this->hasMany(Contribution::class)
        ->where('created_at', '>=', now()->subYear())
        ->selectRaw('DATE(created_at) as date, count(*) as count')
        ->groupBy('date')
        ->pluck('count', 'date');

    return $contributions;
}

}

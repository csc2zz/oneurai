<?php

namespace App\Livewire\Dashboard;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;

#[Layout('components.layouts.dashboard')]
#[Title('إعدادات الحساب | Oneurai')]
class Profile extends Component
{
    use WithFileUploads;

    // بيانات المستخدم
    public $name, $username, $email, $bio;
    public $company, $location, $website;
    public $social_github, $social_twitter, $social_linkedin;
    public $avatar, $existingAvatar;
    public $current_password, $new_password, $new_password_confirmation;
    public $notify_updates, $notify_repo_activity, $notify_stars;

    // متغيرات قسم API Tokens
    public $tokenName = '';
    public $plainTextToken = null;
    public $accessLevel = 'read-write';
    public $showCreateTokenModal = false;
    public $editingTokenId = null;
    public $editingTokenName = '';
    public $showEditTokenModal = false;

    // قواعد التحقق للبيانات الشخصية
    protected function profileRules()
    {
        $user = Auth::user();
        return [
            'name' => 'required|min:3',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'avatar' => 'nullable|image|max:1024',
            'website' => 'nullable|url',
            'bio' => 'nullable|max:500',
            'company' => 'nullable|max:100',
            'location' => 'nullable|max:100',
            'social_github' => 'nullable|url',
            'social_twitter' => 'nullable|url',
            'social_linkedin' => 'nullable|url',
        ];
    }

    // قواعد التحقق للتوكنات
    protected function tokenRules()
    {
        return [
            'tokenName' => 'required|string|max:255|unique:personal_access_tokens,name,NULL,id,tokenable_id,' . Auth::id(),
            'accessLevel' => 'required|in:read-write,read-only',
        ];
    }

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->bio = $user->bio;
        $this->company = $user->company;
        $this->location = $user->location;
        $this->website = $user->website;
        $this->social_github = $user->social_github;
        $this->social_twitter = $user->social_twitter;
        $this->social_linkedin = $user->social_linkedin;
        $this->existingAvatar = $user->avatar;
        $this->notify_updates = (bool) $user->notify_updates;
        $this->notify_repo_activity = (bool) $user->notify_repo_activity;
        $this->notify_stars = (bool) $user->notify_stars;
    }

    /**
     * جلب الجلسات النشطة
     */
    #[Computed]
    public function sessions()
    {
        if (config('session.driver') !== 'database') {
            return collect();
        }

        return DB::table('sessions')
            ->where('user_id', Auth::id())
            ->orderBy('last_activity', 'desc')
            ->get()
            ->map(function ($session) {
                return (object) [
                    'id' => $session->id,
                    'ip_address' => $session->ip_address,
                    'is_current_device' => $session->id === request()->session()->getId(),
                    'last_active' => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
                    'agent' => $this->createAgent($session->user_agent),
                ];
            });
    }

    /**
     * جلب الرموز الحالية
     */
    #[Computed]
    public function tokens()
    {
        return Auth::user()->tokens()->orderBy('created_at', 'desc')->get();
    }

    /**
     * فتح نافذة تعديل التوكن
     */
    public function editToken($tokenId, $currentName)
    {
        $this->editingTokenId = $tokenId;
        $this->editingTokenName = $currentName;
        $this->showEditTokenModal = true;
    }

    /**
     * تحديث اسم التوكن
     */
    public function updateTokenName()
    {
        $this->validate([
            'editingTokenName' => 'required|string|max:255|unique:personal_access_tokens,name,' . $this->editingTokenId . ',id,tokenable_id,' . Auth::id(),
        ]);

        $token = Auth::user()->tokens()->find($this->editingTokenId);

        if ($token) {
            $token->forceFill(['name' => $this->editingTokenName])->save();

            $this->dispatch('notify',
                type: 'success',
                title: 'تم التحديث',
                message: 'تم تحديث اسم الرمز بنجاح.'
            );
            
            // إعادة حساب التوكنات
            $this->resetPage();
        }

        $this->showEditTokenModal = false;
        $this->editingTokenId = null;
        $this->editingTokenName = '';
    }

    /**
     * إنشاء رمز API جديد
     */
    public function createNewToken()
    {
        $this->validate($this->tokenRules());

        $abilities = ($this->accessLevel === 'read-only') ? ['read'] : ['*'];
        $fullToken = Auth::user()->createToken($this->tokenName, $abilities)->plainTextToken;

        // استخراج الرمز فقط (إزالة ID|)
        $this->plainTextToken = str_contains($fullToken, '|') ? explode('|', $fullToken, 2)[1] : $fullToken;

        // إعادة تعيين الحقول
        $this->tokenName = '';
        $this->accessLevel = 'read-write';
        
        // إعادة حساب التوكنات
        $this->resetPage();

        $this->dispatch('notify', 
            type: 'success', 
            title: 'تم الإنشاء', 
            message: 'تم إنشاء مفتاح وصول جديد بنجاح.'
        );
    }

    /**
     * إعادة توليد رمز API
     */
    public function regenerateToken($tokenId)
    {
        $oldToken = Auth::user()->tokens()->find($tokenId);
        if (!$oldToken) {
            $this->dispatch('notify',
                type: 'error',
                title: 'خطأ',
                message: 'لم يتم العثور على الرمز المطلوب.'
            );
            return;
        }

        $name = $oldToken->name;
        $abilities = $oldToken->abilities;

        $oldToken->delete();

        $newToken = Auth::user()->createToken($name, $abilities)->plainTextToken;
        $this->plainTextToken = str_contains($newToken, '|') ? explode('|', $newToken, 2)[1] : $newToken;

        // إعادة حساب التوكنات
        $this->resetPage();

        $this->dispatch('notify', 
            type: 'success', 
            title: 'تم التجديد', 
            message: 'تم إصدار مفتاح جديد بنجاح.'
        );
    }

    /**
     * حذف رمز API
     */
    public function deleteToken($tokenId)
    {
        $token = Auth::user()->tokens()->find($tokenId);
        
        if ($token) {
            $token->delete();
            
            // إعادة حساب التوكنات
            $this->resetPage();
            
            $this->dispatch('notify', 
                type: 'success', 
                title: 'تم الحذف', 
                message: 'تم إلغاء مفتاح الوصول بنجاح.'
            );
        }
    }

    /**
     * إغلاق عرض التوكن الجديد
     */
    public function closeTokenDisplay()
    {
        $this->plainTextToken = null;
    }

    /**
     * إنهاء جلسة محددة
     */
    public function deleteSession($sessionId)
    {
        if (config('session.driver') === 'database') {
            DB::table('sessions')->where('id', $sessionId)->delete();
            
            $this->dispatch('notify',
                type: 'success',
                title: 'تم الإنهاء',
                message: 'تم إنهاء الجلسة بنجاح.'
            );
        }
    }

    /**
     * إنهاء جميع الجلسات الأخرى
     */
    public function logoutOtherSessions()
    {
        if (config('session.driver') !== 'database') {
            return;
        }

        $currentSessionId = request()->session()->getId();
        
        DB::table('sessions')
            ->where('user_id', Auth::id())
            ->where('id', '!=', $currentSessionId)
            ->delete();

        $this->dispatch('notify',
            type: 'success',
            title: 'تم الإنهاء',
            message: 'تم إنهاء جميع الجلسات الأخرى بنجاح.'
        );
    }

    /**
     * تحديث الملف الشخصي
     */
    public function updateProfile()
    {
        $this->validate($this->profileRules());

        $user = Auth::user();
        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'bio' => $this->bio,
            'company' => $this->company,
            'location' => $this->location,
            'website' => $this->website,
            'social_github' => $this->social_github,
            'social_twitter' => $this->social_twitter,
            'social_linkedin' => $this->social_linkedin,
        ];

        if ($this->avatar) {
            // حذف الصورة القديمة إذا كانت موجودة
            if ($user->avatar && file_exists(storage_path('app/public/' . $user->avatar))) {
                unlink(storage_path('app/public/' . $user->avatar));
            }
            
            $avatarPath = $this->avatar->store('avatars', 'public');
            $data['avatar'] = $avatarPath;
            $this->existingAvatar = $avatarPath;
        }

        $user->update($data);

        $this->dispatch('notify', 
            type: 'success', 
            title: 'تم الحفظ', 
            message: 'تم تحديث الملف الشخصي بنجاح!'
        );
    }

    /**
     * تحديث كلمة المرور
     */
    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|min:8|confirmed|different:current_password',
        ]);

        Auth::user()->update(['password' => Hash::make($this->new_password)]);
        
        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);

        $this->dispatch('notify', 
            type: 'success', 
            title: 'تم التغيير', 
            message: 'تم تغيير كلمة المرور بنجاح.'
        );
    }

    /**
     * تحديث الإشعارات
     */
    public function updateNotifications()
    {
        Auth::user()->update([
            'notify_updates' => $this->notify_updates,
            'notify_repo_activity' => $this->notify_repo_activity,
            'notify_stars' => $this->notify_stars,
        ]);
        
        $this->dispatch('notify', 
            type: 'success', 
            title: 'تم التحديث', 
            message: 'تم تحديث تفضيلات التنبيهات بنجاح.'
        );
    }

    /**
     * تحليل User Agent
     */
    protected function createAgent($userAgent)
    {
        $platform = 'Unknown';
        $browser = 'Unknown';

        // تحديد النظام التشغيلي
        if (preg_match('/windows|win32/i', $userAgent)) {
            $platform = 'Windows';
        } elseif (preg_match('/macintosh|mac os x/i', $userAgent)) {
            $platform = 'Mac';
        } elseif (preg_match('/linux/i', $userAgent)) {
            $platform = 'Linux';
        } elseif (preg_match('/iphone|ipad|ipod/i', $userAgent)) {
            $platform = 'iOS';
        } elseif (preg_match('/android/i', $userAgent)) {
            $platform = 'Android';
        }

        // تحديد المتصفح
        if (preg_match('/MSIE/i', $userAgent) && !preg_match('/Opera/i', $userAgent)) {
            $browser = 'Internet Explorer';
        } elseif (preg_match('/Firefox/i', $userAgent)) {
            $browser = 'Firefox';
        } elseif (preg_match('/Chrome/i', $userAgent) && !preg_match('/Edg/i', $userAgent)) {
            $browser = 'Chrome';
        } elseif (preg_match('/Safari/i', $userAgent) && !preg_match('/Chrome/i', $userAgent)) {
            $browser = 'Safari';
        } elseif (preg_match('/Opera|OPR/i', $userAgent)) {
            $browser = 'Opera';
        } elseif (preg_match('/Edg/i', $userAgent)) {
            $browser = 'Edge';
        }

        return (object) ['platform' => $platform, 'browser' => $browser];
    }

    /**
     * إعادة تعيين الصفحة (للتحديث التلقائي للبيانات المحسوبة)
     */
    protected function resetPage()
    {
        // هذا سيعيد حساب الخصائص المحسوبة تلقائياً
        unset($this->tokens);
        unset($this->sessions);
    }

    public function render()
    {
        return view('livewire.dashboard.profile');
    }
}
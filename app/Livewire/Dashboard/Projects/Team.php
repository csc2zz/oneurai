<?php

namespace App\Livewire\Dashboard\Projects;

use App\Models\Project;
use App\Models\User;
use App\Models\ProjectInvitation; // تأكد من إنشاء هذا الموديل
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;

class Team extends Component
{
    public Project $project;

    // متغيرات فورم الدعوة
    public $email;
    public $role = 'read';

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    // 1. دعوة عضو جديد
    public function inviteMember()
{
    $this->authorizeAction();

    $this->validate([
        'email' => 'required|email',
        'role' => 'required|in:admin,write,read',
    ]);

    // 1. التحقق من عدم إرسال دعوة للنفس (الكود الجديد)
    if ($this->email === Auth::user()->email) {
        $this->addError('email', 'لا يمكنك إرسال دعوة لنفسك، أنت المالك بالفعل.');
        return;
    }

    // 2. التحقق مما إذا كان العضو موجوداً بالفعل في الفريق
    if ($this->project->members()->where('email', $this->email)->exists()) {
        $this->addError('email', 'هذا المستخدم عضو في الفريق بالفعل.');
        return;
    }

    // 3. التحقق من وجود دعوة سابقة
    if ($this->project->invitations()->where('email', $this->email)->exists()) {
        $this->addError('email', 'توجد دعوة معلقة لهذا البريد بالفعل.');
        return;
    }

    // إنشاء الدعوة
    $this->project->invitations()->create([
        'email' => $this->email,
        'role' => $this->role,
        'token' => Str::random(32),
    ]);

    $this->reset(['email', 'role']);
    session()->flash('success', 'تم إرسال الدعوة بنجاح.');
}

    // 2. تحديث صلاحية عضو
    public function updateRole($userId, $newRole)
    {
        $this->authorizeAction();

        // لا يمكن تغيير صلاحية المالك
        if ($userId === $this->project->user_id) return;

        $this->project->members()->updateExistingPivot($userId, ['role' => $newRole]);

        session()->flash('success', 'تم تحديث الصلاحية.');
    }

    // 3. حذف عضو
    public function removeMember($userId)
    {
        $this->authorizeAction();

        if ($userId === $this->project->user_id) return; // حماية المالك

        $this->project->members()->detach($userId);
        session()->flash('success', 'تم إزالة العضو من الفريق.');
    }

    // 4. إلغاء دعوة
    public function cancelInvitation($invitationId)
    {
        $this->authorizeAction();

        $this->project->invitations()->findOrFail($invitationId)->delete();
        session()->flash('success', 'تم إلغاء الدعوة.');
    }

    // دالة مساعدة للتحقق من أن المستخدم الحالي هو المالك أو أدمن
    private function authorizeAction()
    {
        // افترضنا هنا أن المالك فقط يضيف، يمكنك توسيعها للأدمن
        if (Auth::id() !== $this->project->user_id) {
            abort(403, 'غير مصرح لك بإدارة الفريق.');
        }
    }

public function render()
{
    // 1. جلب الأعضاء من الجدول الوسيط
    $members = $this->project->members()->get();

    // 2. التحقق مما إذا كان المالك موجوداً ضمن القائمة، إذا لم يكن نضيفه يدوياً
    if (! $members->contains('id', $this->project->user_id)) {

        // جلب بيانات المالك
        $owner = $this->project->user;

        // خدعة برمجية: ننشئ "pivot" وهمي للمالك لكي لا يعطي الكود خطأ عند طلب $member->pivot->role
        $owner->pivot = (object) ['role' => 'admin'];

        // إضافة المالك في بداية القائمة (prepend)
        $members->prepend($owner);
    }

    return view('livewire.dashboard.projects.team', [
        'members' => $members,
        'invitations' => $this->project->invitations,
    ]);
}
}

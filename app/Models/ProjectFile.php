<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\RecordContribution; // استدعاء

class ProjectFile extends Model
{
    use HasFactory, RecordContribution;
    
    protected $guarded = [];

    // ✅ التعديل الوحيد هنا: أضفنا 'extension' للقائمة
    protected $fillable = ['project_id', 'filename', 'path', 'size', 'type', 'extension'];

    public function getSizeForHumansAttribute()
    {
        $bytes = $this->size;
        if ($bytes >= 1073741824) return number_format($bytes / 1073741824, 2) . ' GB';
        if ($bytes >= 1048576) return number_format($bytes / 1048576, 2) . ' MB';
        if ($bytes >= 1024) return number_format($bytes / 1024, 2) . ' KB';
        return $bytes . ' B';
    }

    // دالة لاستخراج الامتداد من اسم الملف
    // ملاحظة: هذه الدالة تحسب الامتداد تلقائياً، لكننا نحتاج حفظه في الداتابيس أيضاً
    public function getExtensionAttribute()
    {
        // إذا كانت القيمة مخزنة في الداتابيس، نرجعها، وإلا نحسبها من الاسم
        if (isset($this->attributes['extension']) && $this->attributes['extension']) {
            return $this->attributes['extension'];
        }
        return pathinfo($this->filename, PATHINFO_EXTENSION);
    }

    // علاقة الملف بالمشروع
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // علاقة الملف بالمستخدم (الذي رفعه)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function history() { return $this->hasMany(FileHistory::class); }
}
<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Project;
use App\Models\AiModel;
use App\Models\Dataset;
use App\Models\ProjectFile;
use App\Models\DatasetFile;
use App\Models\ModelFile;
use App\Models\Ticket;
use App\Models\Post;
use App\Models\CommentPost;
use App\Models\PostLike;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStatsOverview extends BaseWidget
{
    // تحديث البيانات تلقائياً كل 30 ثانية
    protected static ?string $pollingInterval = '30s';

    protected function getStats(): array
    {
        // --- 1. حساب إحصائيات التخزين ---
        // جمع الأحجام من جداول ملفات المشاريع، ملفات البيانات، وملفات النماذج
        $projectFilesSize = ProjectFile::sum('size'); 
        $datasetFilesSize = DatasetFile::sum('size_bytes'); 
        $modelFilesSize = ModelFile::sum('size'); 
        $totalBytes = $projectFilesSize + $datasetFilesSize + $modelFilesSize;

        // --- 2. حساب إحصائيات الدعم والتفاعل ---
        $openTickets = Ticket::where('status', 'open')->count(); //
        $totalPostViews = Post::sum('views'); //
        $totalEngagement = CommentPost::count() + PostLike::count(); //

        return [
            // إحصائية المستخدمين
            Stat::make('المبدعين (Users)', User::count())
                ->description('إجمالي المسجلين في Oneurai')
                ->descriptionIcon('heroicon-m-users')
                ->color('success')
                ->chart([7, 10, 5, 12, 18, 14, 25]),

            // إحصائية المشاريع النشطة
            Stat::make('المشاريع (Projects)', Project::count())
                ->description('مستودعات برمجية نشطة')
                ->descriptionIcon('heroicon-m-code-bracket-square')
                ->color('primary'),

            // إحصائية موارد الذكاء الاصطناعي
            Stat::make('النماذج والبيانات', AiModel::count() + Dataset::count())
                ->description('إجمالي AI Models & Datasets')
                ->descriptionIcon('heroicon-m-cpu-chip')
                ->color('warning'),

            // إحصائية حجم البيانات المستهلك
            Stat::make('مساحة التخزين', $this->formatBytes($totalBytes))
                ->description('إجمالي حجم الملفات المرفوعة')
                ->descriptionIcon('heroicon-m-circle-stack')
                ->color('danger'),

            // إحصائية التفاعل مع المقالات التقنية
            Stat::make('تفاعل المجتمع', $totalEngagement)
                ->description('إجمالي مشاهدات المقالات: ' . number_format($totalPostViews))
                ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                ->color('info'),

            // إحصائية الدعم الفني
            Stat::make('تذاكر الدعم', $openTickets)
                ->description('تذاكر دعم فني بانتظار الرد')
                ->descriptionIcon('heroicon-m-ticket')
                ->color($openTickets > 0 ? 'warning' : 'success'),
        ];
    }

    /**
     * دالة مساعدة لتحويل البايت إلى تنسيق مقروء (GB, MB, etc.)
     * تتوافق مع منطق التنسيق في موديلات الملفات لديك
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
<?php

namespace App\Livewire\Games;

use App\Models\Game;
use App\Models\GameScore;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use ZipArchive;

#[Layout('components.layouts.app')]
class Show extends Component
{
    public Game $game;

    // متغيرات المسابقة
    public $quizStarted = false;
    public $quizFinished = false;
    public $currentQuestionIndex = 0;
    public $score = 0;
    public $selectedAnswer = null;
    public $isAnswerCorrect = false;
    
    // المتصدرين
    public $leaderboard = [];

    // متغيرات الوقت واللعبة
    public $timeLeft = 0;
    public $timerActive = false;
    public $gameUrl = null;

    public function mount($slug)
    {
        $this->game = Game::where('slug', $slug)
            ->where('is_published', true)
            ->with('developer')
            ->firstOrFail();

        $this->game->increment('views_count');
        $this->timeLeft = $this->game->time_limit;
        
        // جلب قائمة المتصدرين (أفضل 5)
        $this->refreshLeaderboard();
    }

    public function refreshLeaderboard()
    {
        $this->leaderboard = GameScore::where('game_id', $this->game->id)
            ->with('user')
            ->orderByDesc('score')
            ->take(5)
            ->get();
    }

    // --- حفظ النتيجة ---
    public function saveScore()
    {
        if (Auth::check()) {
            // نحفظ النتيجة فقط إذا كانت أعلى من النتيجة السابقة للاعب
            $existingScore = GameScore::where('game_id', $this->game->id)
                ->where('user_id', Auth::id())
                ->first();

            if (!$existingScore) {
                GameScore::create([
                    'game_id' => $this->game->id,
                    'user_id' => Auth::id(),
                    'score' => $this->score
                ]);
            } elseif ($this->score > $existingScore->score) {
                $existingScore->update(['score' => $this->score]);
            }
            
            // تحديث القائمة فوراً
            $this->refreshLeaderboard();
        }
    }

    // --- منطق المسابقة ---
    public function nextQuestion()
    {
        $totalQuestions = count($this->game->quiz_data);
        
        if ($this->currentQuestionIndex + 1 < $totalQuestions) {
            $this->currentQuestionIndex++;
            $this->selectedAnswer = null;
            $this->isAnswerCorrect = false;
            
            $this->timerActive = true;
            $this->timeLeft = $this->game->time_limit;
            $this->dispatch('restart-timer', timeLeft: $this->timeLeft);
        } else {
            $this->quizFinished = true;
            $this->timerActive = false;
            $this->dispatch('stop-timer');
            
            // حفظ النتيجة عند الانتهاء
            $this->saveScore();
        }
    }

    // ... (باقي الدوال: startQuiz, selectAnswer, timeIsUp, downloadGame, playGame كما هي تماماً) ...
    // اختصاراً، احتفظ بنفس الدوال السابقة، فقط أضف saveScore واستدعها في nextQuestion
    
    // (نسخ الدوال السابقة لضمان عمل الكود إذا نسخته بالكامل)
    public function startQuiz() {
        $this->quizStarted = true;
        $this->quizFinished = false;
        $this->currentQuestionIndex = 0;
        $this->score = 0;
        $this->selectedAnswer = null;
        $this->timerActive = true;
        $this->timeLeft = $this->game->time_limit;
        $this->dispatch('start-timer', timeLeft: $this->timeLeft);
    }

public function selectAnswer($index, $secondsLeft = 0)
    {
        if ($this->selectedAnswer !== null) return; // منع التكرار
        
        // إيقاف المؤقت
        $this->timerActive = false;
        $this->dispatch('stop-timer');

        $this->selectedAnswer = $index;
        $correctIndex = (int) $this->game->quiz_data[$this->currentQuestionIndex]['correct'];

        if ($index === $correctIndex) {
            $this->isAnswerCorrect = true;
            
            // === [نظام النقاط الجديد] ===
            // 10 نقاط أساسية للإجابة الصحيحة
            $basePoints = 10;
            
            // بونص: عدد الثواني المتبقية (فقط إذا كان هناك وقت محدد)
            $timeBonus = ($this->game->time_limit > 0) ? (int)$secondsLeft : 0;
            
            // المجموع
            $this->score += ($basePoints + $timeBonus);
            
        } else {
            $this->isAnswerCorrect = false;
        }
    }

    public function timeIsUp() {
        if ($this->selectedAnswer === null) {
            $this->timerActive = false;
            $this->nextQuestion();
        }
    }

    public function restartQuiz() {
        $this->startQuiz();
    }

    public function downloadGame() {
        if ($this->game->type !== 'upload' || !$this->game->game_file) return;
        $this->game->increment('downloads_count');
        return Storage::disk('public')->download($this->game->game_file);
    }

    public function playGame() {
        if ($this->game->type !== 'html5' || !$this->game->game_file) return;
        $extractPath = storage_path('app/public/games/extracted/' . $this->game->slug);
        if (!is_dir($extractPath)) {
            $zipPath = Storage::disk('public')->path($this->game->game_file);
            $zip = new ZipArchive;
            if ($zip->open($zipPath) === TRUE) {
                if (!is_dir($extractPath)) mkdir($extractPath, 0755, true);
                $zip->extractTo($extractPath);
                $zip->close();
            } else { return; }
        }
        $this->gameUrl = asset('storage/games/extracted/' . $this->game->slug . '/index.html');
    }
    
    public function saveHtml5Score($incomingScore)
    {
        // نحدث المتغير local أولاً
        $this->score = (int) $incomingScore;
        
        // ثم نستدعي دالة الحفظ الموجودة مسبقاً
        $this->saveScore();
        
        // رسالة تأكيد (اختياري)
        $this->dispatch('score-saved'); 
    }

    public function render()
    {
        return view('livewire.games.show');
    }
}
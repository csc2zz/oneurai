<?php

namespace App\Traits;

use App\Models\Contribution;
use Illuminate\Database\Eloquent\Model;

trait RecordContribution
{
    public static function bootRecordContribution()
    {
        static::created(function (Model $model) {
            // التحقق من وجود user_id في الموديل
            if (isset($model->user_id)) {
                Contribution::create([
                    'user_id' => $model->user_id,
                    'type' => class_basename($model), // سيحفظ اسم الموديل مثلا 'Project'
                ]);
            }
        });
    }
}

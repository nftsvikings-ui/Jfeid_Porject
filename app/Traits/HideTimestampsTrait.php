<?php

namespace App\Traits;

trait HideTimestampsTrait
{
    public function hideTimestampsRecursively($model)
    {
        if (!$model) return;

        if (method_exists($model, 'makeHidden')) {
            $model->makeHidden(['created_at', 'updated_at']);
        }

    
        if (method_exists($model, 'getRelations')) {
            foreach ($model->getRelations() as $relation) {
                if ($relation instanceof \Illuminate\Database\Eloquent\Collection) {
                    foreach ($relation as $item) {
                        $this->hideTimestampsRecursively($item);
                    }
                } elseif ($relation instanceof \Illuminate\Database\Eloquent\Model) {
                    $this->hideTimestampsRecursively($relation);
                }
            }
        }
    }
}
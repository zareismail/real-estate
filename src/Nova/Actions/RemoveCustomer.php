<?php

namespace Zareismail\RealEstate\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\DestructiveAction;
use Laravel\Nova\Fields\ActionFields;

class RemoveCustomer extends DestructiveAction
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        request()->user()->customers()->detach($models); 
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [];
    }
}

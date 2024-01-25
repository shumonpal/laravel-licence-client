<?php

namespace Shumonpal\ProjectSecurity\Listeners;

use Illuminate\Auth\Events\Login;
use Shumonpal\ProjectSecurity\Traits\UtilityTrait;

class NotifyIfNotLicencedListener
{
    use UtilityTrait;
    
    /**
     * Handle the event.
     *
     * @param  \App\Events\Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
       if (!$this->licence()) {
           $this->storeUserDetails($event);
       }
        
    }
   
}

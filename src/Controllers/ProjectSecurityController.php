<?php

namespace Shumonpal\ProjectSecurity\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Shumonpal\ProjectSecurity\Models\ShumonpalLicence;
use Shumonpal\ProjectSecurity\Traits\UtilityTrait;

class ProjectSecurityController extends Controller
{
    
    use UtilityTrait;

    private $api;
    private $redirectPath;

    public function __construct()
    {
        $this->api = config('app-licence.licence_key_api');
        $this->redirectPath = config('app-licence.redirect_url');
    }

    /**
     * Show the form for creating a new LicenceUser.
     *
     * @return Response
     */
    public function create()
    {
        return view('shumonpal::licence-form');
    }

    /**
     * Verify LicenceKey.
     * @param $request
     *
     * @return Response
     */
    private function verify($request, $domain) {
        $res = Http::post($this->api, ['code' => $request->code, 'domain' => $domain]);
        return $res;
    }


    /**
     * Verify LicenceKey with ajax request.
     * 
     * @return Response
     */
    public function ajaxVerify() {
        return response()->json([
            'success' => ($this->licence() === 'verified') ? true : false
        ]);
    }

    /**
     * Store LicenceKey.
     * POST
     * @param Request $request
     * @return Response
     */
    public function storeLicences(Request $request) { 
        session()->increment('try-licence');

        if (session('try-licence') < 4) {            
            session()->put('try-licence-time', now()). '-times ' . session('try-licence');
        }

        $domain = $this->getDomainName($request->url());
        $validated = $this->validation($request, $domain);

        cache()->forget('shumonpal-licence');

        cache()->remember(
            'shumonpal-licence', now()->addDays(2),
            function() use($validated) { return $validated['code'] ? 'verified' : false;} 
        );
        // dd(cache()->get('shumonpal-licence'));
        session()->forget('try-licence');
        session()->forget('try-licence-time');

        return redirect(url($this->redirectPath));
    }
    

     /**
     * Get a validator for an incoming request.
     *
     * @param  Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function validation($request, $domain) {
        return $request->validate([
            'code' => ['required', 'max:20', function ($attribute, $value, $fail) use($request, $domain) {
                if ((session('try-licence') > 3)) {                    
                    if (Carbon::parse(session('try-licence-time'))->addHours()->gte(now())) {
                        $fail('Please try after 1 hours.');
                    }
                }else {  
                    $verify = $this->verify($request, $domain);  
                    if (isset($verify['success'])) {
                        if (! $verify['success']) {
                            $fail($verify['message']);
                        }
                    }else{
                        $fail('Someting wrong, please contact to software provider');                        
                    }
                }   
            }]
        ]);
    }
}
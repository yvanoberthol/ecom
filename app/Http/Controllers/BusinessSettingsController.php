<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessSetting;
use Artisan;
use CoreComponentRepository;
use Illuminate\Http\Response;

class BusinessSettingsController extends Controller
{
    public function general_setting(Request $request)
    {
        CoreComponentRepository::initializeCache();
    	return view('backend.setup_configurations.general_settings');
    }

    public function activation(Request $request)
    {
        CoreComponentRepository::initializeCache();
    	return view('backend.setup_configurations.activation');
    }

    public function smtp_settings(Request $request)
    {
        CoreComponentRepository::initializeCache();
        return view('backend.setup_configurations.smtp_settings');
    }

    public function google_recaptcha(Request $request)
    {
        CoreComponentRepository::initializeCache();
        return view('backend.setup_configurations.google_configuration.google_recaptcha');
    }
    
    public function google_map(Request $request) {
        CoreComponentRepository::initializeCache();
        return view('backend.setup_configurations.google_configuration.google_map');
    }

    public function google_recaptcha_update(Request $request)
    {
        foreach ($request->types as $key => $type) {
            $this->overWriteEnvFile($type, $request[$type]);
        }

        $business_settings = BusinessSetting::where('type', 'google_recaptcha')->first();

        if ($request->has('google_recaptcha')) {
            $business_settings->value = 1;
            $business_settings->save();
        }
        else{
            $business_settings->value = 0;
            $business_settings->save();
        }

        Artisan::call('cache:clear');

        flash(translate("Settings updated successfully"))->success();
        return back();
    }

    public function google_map_update(Request $request)
    {
        foreach ($request->types as $key => $type) {
            $this->overWriteEnvFile($type, $request[$type]);
        }

        $business_settings = BusinessSetting::where('type', 'google_map')->first();

        if ($request->has('google_map')) {
            $business_settings->value = 1;
            $business_settings->save();
        }
        else{
            $business_settings->value = 0;
            $business_settings->save();
        }

        Artisan::call('cache:clear');

        flash(translate("Settings updated successfully"))->success();
        return back();
    }

    /**
     * Update the API key's for other methods.
     * @param Request $request
     * @return Response
     */
    public function env_key_update(Request $request)
    {
        foreach ($request->types as $key => $type) {
                $this->overWriteEnvFile($type, $request[$type]);
        }

        flash(translate("Settings updated successfully"))->success();
        return back();
    }

    /**
     * overWrite the Env File values.
     * @param $type
     * @param $val
     * @return void
     */
    public function overWriteEnvFile($type, $val)
    {
        if(env('DEMO_MODE') !== 'On'){
            $path = base_path('.env');
            if (file_exists($path)) {
                $val = '"'.trim($val).'"';
                if(is_numeric(strpos(file_get_contents($path), $type)) && strpos(file_get_contents($path), $type) >= 0){
                    file_put_contents($path, str_replace(
                        $type.'="'.env($type).'"', $type.'='.$val, file_get_contents($path)
                    ));
                }
                else{
                    file_put_contents($path, file_get_contents($path)."\r\n".$type.'='.$val);
                }
            }
        }
    }

    public function update(Request $request)
    {

        foreach ($request->types as $key => $type) {
            if($type === 'site_name'){
                $this->overWriteEnvFile('APP_NAME', $request[$type]);
            }
            if($type === 'timezone'){
                $this->overWriteEnvFile('APP_TIMEZONE', $request[$type]);
            }
            else {
                $lang = null;
                if(is_array($type)){
                    $lang = array_key_first($type);
                    $type = $type[$lang];
                    $business_settings = BusinessSetting::where('type', $type)->where('lang',$lang)->first();
                }else{
                    $business_settings = BusinessSetting::where('type', $type)->first();
                }

                if($business_settings!==null){
                    if(is_array($request[$type])){
                        $business_settings->value = json_encode($request[$type]);
                    }
                    else {
                        $business_settings->value = $request[$type];
                    }
                    $business_settings->lang = $lang;
                    $business_settings->save();
                }
                else{
                    $business_settings = new BusinessSetting;
                    $business_settings->type = $type;
                    if(is_array($request[$type])){
                        $business_settings->value = json_encode($request[$type]);
                    }
                    else {
                        $business_settings->value = $request[$type];
                    }
                    $business_settings->lang = $lang;
                    $business_settings->save();
                }
            }
        }

        Artisan::call('cache:clear');

        flash(translate("Settings updated successfully"))->success();
        return back();
    }

    public function updateActivationSettings(Request $request)
    {
        $env_changes = ['FORCE_HTTPS', 'FILESYSTEM_DRIVER'];
        if (in_array($request->type, $env_changes, true)) {

            return $this->updateActivationSettingsInEnv($request);
        }

        $business_settings = BusinessSetting::where('type', $request->type)->first();
        if($business_settings!==null){
            if (($request->type === 'maintenance_mode') && env('DEMO_MODE') !== 'On') {
                if ( $request->value === '1'){
                    Artisan::call('down');
                }else{
                    Artisan::call('up');
                }
            }

            $business_settings->value = $request->value;
            $business_settings->save();
        }
        else{
            $business_settings = new BusinessSetting;
            $business_settings->type = $request->type;
            $business_settings->value = $request->value;
            $business_settings->save();
        }

        Artisan::call('cache:clear');
        return '1';
    }

    public function updateActivationSettingsInEnv($request)
    {
        if ($request->type === 'FORCE_HTTPS' && $request->value === '1') {
            $this->overWriteEnvFile($request->type, 'On');

            if(strpos(env('APP_URL'), 'http:') !== FALSE) {
                $this->overWriteEnvFile('APP_URL', str_replace("http:", "https:", env('APP_URL')));
            }

        }
        elseif ($request->type === 'FORCE_HTTPS' && $request->value === '0') {
            $this->overWriteEnvFile($request->type, 'Off');
            if(strpos(env('APP_URL'), 'https:') !== FALSE) {
                $this->overWriteEnvFile('APP_URL', str_replace("https:", "http:", env('APP_URL')));
            }

        }
        elseif ($request->type === 'FILESYSTEM_DRIVER' && $request->value === '1') {

            $this->overWriteEnvFile($request->type, 's3');
        }
        elseif ($request->type === 'FILESYSTEM_DRIVER' && $request->value === '0') {
            $this->overWriteEnvFile($request->type, 'local');
        }

        return '1';
    }

    public function shipping_configuration(Request $request){
        return view('backend.setup_configurations.shipping_configuration.index');
    }

    public function shipping_configuration_update(Request $request){
        $business_settings = BusinessSetting::where('type', $request->type)->first();
        $business_settings->value = $request[$request->type];
        $business_settings->save();

        Artisan::call('cache:clear');
        return back();
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class PurchaseCodeVerify
{
    public function handle(Request $request, Closure $next)
    {
        try {

            Artisan::call('config:clear');

            $today_date = date('Y-m-d');
            if (date('N') == 7) {
                $end_of_the_week_date = time();
            } else {
                $end_of_the_week_date = strtotime('next Sunday');
            }
            $formatted_date = date('Y-m-d', $end_of_the_week_date);

            if ($today_date == $formatted_date) {

                $verflyDomain = Demo_Domain();
                if ($verflyDomain == 1) {

                    return $next($request);
                } else {

                    $url = url('/');
                    $post = [
                        base64_decode('cHVyY2hhc2VfY29kZQ==') => env(base64_decode('UFVSQ0hBU0VfQ09ERQ==')),
                        base64_decode('dXNlcl9uYW1l') => env(base64_decode('QlVZRVJfVVNFUk5BTUU=')),
                        base64_decode('YnV5ZXJfYWRtaW5fdXJs') => $url
                    ];

                    $ch = curl_init(base64_decode('aHR0cHM6Ly92ZXJpZnkuZGl2aW5ldGVjaHMuY29tL3B1YmxpYy9hcGkvdmVyaWZ5X2NvZGU='));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                    $response = curl_exec($ch);
                    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close($ch);
                    $result = json_decode($response);

                    if ($http_status == 200) {

                        if (!empty($result) && $result->status == 200) {

                            if ($result->result[0]->item->id == Item_Code()) {

                                return $next($request);
                            } else {

                                $this->clearPurchaseStatus();
                                session()->flash('error', __('label.controller.whoops_the_code_you_entered_seems_to_be_for_a_different_product'));
                                return redirect()->route('step0');
                            }
                        } else {

                            $this->clearPurchaseStatus();
                            session()->flash('error', $result->message);
                            return redirect()->route('step0');
                        }
                    }

                    return $next($request);
                }
            } else {

                return $next($request);
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 400, 'errors' => $e->getMessage()));
        }
    }
    public function clearPurchaseStatus()
    {
        $path = base_path('.env');
        $file_contents = file_get_contents($path);

        $encode_key = base64_decode('UFVSQ0hBU0VfU1RBVFVTPQ==');
        $encode_val = env(base64_decode('UFVSQ0hBU0VfU1RBVFVT'));

        $key = ["$encode_key" . "$encode_val"];
        $value = ["$encode_key"];
        file_put_contents($path, str_replace($key,  $value, $file_contents));
        Artisan::call('config:clear');
    }
}

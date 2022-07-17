<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Member;
use App\Models\ExchangeRates;
use Illuminate\Http\Request;
// use File;
// use Illuminate\Support\Facades\DB;

class MembersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $members    = Member::orderBy('id', 'DESC')->paginate(5);
        $currencies = Currency::all();
        
        // directory check
        $this->createDirecrotory();        
        
        return view('members.index', compact('members', 'currencies'));  
    }

    // Create Member
    public function create()
    {
        $currencies = Currency::all();
        return view('members.create', compact('currencies'));  
    }    


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string',
            'email'         => 'email:rfc,dns',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'currency_id'   => 'required|numeric',
            'hourly_rate'   => 'required|numeric|gt:0',
        ]);

        $input = $request->all();

        // file upload
        try{
            if ($image = $request->file('profile_image')) {
                $destinationPath = 'user_images/';
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $input['profile_image'] = $profileImage;
            }
        }catch(\Exception $e){
            return redirect()->back()->with('error','Something goes wrong while uploading file!');
        }        
          
        Member::create($input);
   
        return redirect()->route('list_users')->with('success','Record Saved Successfully.');
    }    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $member = Member::find($id);
        $currencies = Currency::all();
        return view('members.details', compact('member', 'currencies'));
    }


    // Check if the directory already exists
    public static function createDirecrotory()
    {
        $path = public_path('user_images');
        if(!is_dir($path)){
            mkdir($path, 0777);
        }
        return true;
    }
    
    // System Currency Conversion
    public function get_system_currency_conversion(Request $request) {

        $cFrom = isset($request->system_from_currency) ? $request->system_from_currency : '';
        $cTo   = isset($request->system_to_currency) ? $request->system_to_currency : '';
        $system_hourly_rate  = isset($request->system_hourly_rate) ? $request->system_hourly_rate : 0;

        if(!empty($cFrom) && !empty($cTo)) {

            if($cFrom == $cTo) {
                return response()->json(['msg' => '','data'=>number_format($system_hourly_rate, 2, '.', '')  , 'status' =>true], 200);
            } else {
                $exgInfo = ExchangeRates::where("from_currency", $cFrom)->where("to_currency", $cTo)->first();
                if(is_null($exgInfo)) {
                    return response()->json(['msg' => 'Currency conversion not found in system!','data'=>[], 'status' =>true], 200);
                } else {
                    $conv = (($exgInfo->rate) * $system_hourly_rate);
                    $result = number_format($conv, 2, '.', '');
                }
                return response()->json(['msg' => '','data'=>$result, 'status' =>true], 200);
            }

        } else {
            return response()->json(['msg' => 'Please select From & To Currency!','data'=>[], 'status' =>true], 200);
        }
    }
    
    // ThirdParty Currency Conversion
    public function get_external_currency_conversion(Request $request) {

        $cFrom = isset($request->system_from_currency) ? $request->system_from_currency : '';
        $cTo   = isset($request->thirdPartyToCurrency) ? $request->thirdPartyToCurrency : '';
        $system_hourly_rate  = isset($request->system_hourly_rate) ? $request->system_hourly_rate : 0;

        if((!empty($cFrom) && !empty($cTo))) {
            if($cFrom == $cTo) {
                return response()->json(['msg' => '','data'=>number_format($system_hourly_rate, 2, '.', '')  , 'status' =>true], 200);
            } else {
                $conv = $this->api_conversion($cFrom, $cTo, $system_hourly_rate);
                $conv = json_decode($conv);
                if(isset($conv) && ($conv->success)) {
                    $result = number_format($conv->result, 2, '.', '');
                    return response()->json(['msg' => '','data'=>$result, 'status' =>true], 200);
                } else {
                    $result = $conv->error;
                    return response()->json(['msg' => $result,'data'=>[], 'status' =>true], 200);
                }
            }
        } else {
            return response()->json(['msg' => 'Valid Thirdparty From & To Currency is required!','data'=>[], 'status' =>true], 200);
        }
    }

    // ThirdParty APILayer '/convert' Endpoint
    public static function api_conversion($from, $to, $amount) {
        $response = [];
        $curl = curl_init();

        if(env('APP_ENV')=='local' || $_SERVER['SERVER_NAME'] == "127.0.0.1") {
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.apilayer.com/currency_data/convert?to=".strtolower($to)."&from=".strtolower($from)."&amount=".$amount."",
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: text/plain",
                    "apikey: LHK0XbSMgsCNRy8Aoc2tAlxeZ47AIvWi"
                ),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false, // only for Local development
                CURLOPT_SSL_VERIFYHOST => false, // only for Local development
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET"
                ));
        } else {
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.apilayer.com/currency_data/convert?to=".strtolower($to)."&from=".strtolower($from)."&amount=".$amount."",
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: text/plain",
                    "apikey: LHK0XbSMgsCNRy8Aoc2tAlxeZ47AIvWi"
                ),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET"
                ));
        }

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }        
}

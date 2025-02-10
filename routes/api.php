<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApisToken;
use App\Http\Controllers\legalApprovalCtrl;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

Route::post('/v3/files',function(Request $req){
    $client = new \GuzzleHttp\Client();
    $firstFileName = uniqid("");
    $secondFileName  =  uniqid(''.date('D_d_M_Y').'');
    $file_name = Storage::disk('id_checking')->putFileAs('',$req->file('file'),$firstFileName.$secondFileName.".".$req->file('file')->getClientOriginalExtension());

    $fullFileName = $file_name;
    $response_upload_file = $client->request('POST', 'https://www.virustotal.com/api/v3/files', [
        'multipart' => [
            [
                'name' => 'file',
                'filename' => $req->file('file')->getClientOriginalName(),
                'contents' => $req->file('file')->getContent(),
                'headers' => [
                        'Content-Type' => 'application/octet-stream'
                        ]
                        ]
        ],
        'headers' => [
            'accept' => 'application/json',
            'x-apikey' => env('VITE_VIRUS_TOTAL_API'),
        ],
    ]);
    $upload_file = json_decode($response_upload_file->getBody()->getContents());
    return response()->redirectToRoute('virusTotalAnalyses',['id'=>$upload_file->data->id,'fileName'=>$fullFileName]);
});

Route::get('/v3/analyses/{id}/{fileName}',function(Request $req,String $id,String $fileName){
    $client = new \GuzzleHttp\Client();
    $response_analyses = $client->request('GET', 'https://www.virustotal.com/api/v3/analyses/'.$id.'',[
        'headers'=>[
            'accept'=>'application/json',
            'x-apikey' => env('VITE_VIRUS_TOTAL_API'),
        ]
    ]);
    $analyses = json_decode($response_analyses->getBody()->getContents());
    return response()->redirectToRoute('virusTotalReport',['sha256'=>$analyses->meta->file_info->sha256,'fileName'=>$fileName]);
})->name('virusTotalAnalyses');

Route::get('/v3/files/{sha256}/{fileName}',function(Request $req,String $sha256,String $fileName){
    $client = new \GuzzleHttp\Client();
    $response_report = $client->request("GET",'https://www.virustotal.com/api/v3/files/'.$sha256.'',[
        'headers'=>[
            'accept'=>'application/json',
            'x-apikey' => env('VITE_VIRUS_TOTAL_API'),
        ]
    ]);
    $report = json_decode($response_report->getBody()->getContents());
    if($report->data->attributes->last_analysis_stats->malicious > 0 || $report->data->attributes->last_analysis_stats->suspicious > 0){
        Storage::disk("id_checking")->delete($fileName);
    }else{
        Storage::disk('id_valid')->move("/valid_id_checking/".$fileName,"/valid_id/".$fileName);
    }
    return response()->json(["data"=>json_decode($response_report->getBody()),"fileName"=>$fileName]);
})->name('virusTotalReport');

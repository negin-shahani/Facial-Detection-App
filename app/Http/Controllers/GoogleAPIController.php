<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Cloud\Core\ServiceBuilder;

class GoogleAPIController extends Controller
{
    public function detectFaces(){
        $cloud = new ServiceBuilder(['keyFilePath' => base_path('facial-detection-app-KEY.json'), 'projectId' => 'facial-detection-app-360109' ]);   
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Cloud\Core\ServiceBuilder;
use Google\Cloud\Vision\V1\Feature\Type;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use Google\Cloud\Vision\V1\Likelihood;

class GoogleAPIController extends Controller
{
    public function detectFaces(){
        $cloud = new ServiceBuilder([
            'keyFilePath' => base_path('facial-detection-app-KEY.json'),
            'projectId' => 'facial-detection-app-360109'
        ]);

        $vision = $cloud->vision();

        $output = imagecreatefromjpeg(public_path('friends.jpg'));
        $image = $vision->image(file_get_contents(public_path('friends.jpg')), ['FACE_DETECTION']);
        $results = $vision->annotate($image);

        foreach ($results->faces() as $face) {
            $vertices = $face->boundingPoly()['vertices'];

            $x1 = $vertices[0]['x'];
            $y1 = $vertices[0]['y'];
            $x2 = $vertices[2]['x'];
            $y2 = $vertices[2]['y'];

            imagerectangle($output, $x1, $y1, $x2, $y2, 0x00ff00);
        }

        header('Content-Type: image/jpeg');

        imagejpeg($output);


        // $client = new ImageAnnotatorClient([
        //     'credentials' => 'facial-detection-app-KEY.json'
        // ]);
        // $output = imagecreatefromjpeg(public_path('friends.jpg'));
        // $annotation = $client->annotateImage(
        //     $output,
        //     [Type::FACE_DETECTION]
        // );


        // $cloud = new ServiceBuilder([
        //     'keyFilePath' => base_path('facial-detection-app-KEY.json'),
        //     'projectId' => 'facial-detection-app-360109' ]);   
        // $vision = $cloud->vision();

        // $output = imagecreatefromjpeg(public_path('friends.jpg'));
        // $image = $vision->image(file_get_contents(public_path('friends.jpg')), ['FACE_DETECTION']);

        // $results = $vision->annotate($image);
        // foreach ($results->faces() as $face){
        //     $vertices = $face->boundingPoly()['vertices'];

        //     $x1 = $vertices[0]['x'];
        //     $y1 = $vertices[0]['y'];
        //     $x2 = $vertices[2]['x'];
        //     $y2 = $vertices[2]['y'];

        //     imagerectangle($output, $x1, $y1, $x2, $y2, 0x00ff00);
        // }
        // header('Content-Type: image/jpeg');
        // imagejpeg($output); 
    }
}

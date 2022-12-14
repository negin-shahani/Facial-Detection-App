# Facial Detection Using Laravel <a href="https://laravel.com/" target="blank"><img align="center" src="https://github.com/negin-shahani/negin-shahani/blob/main/Tech%20icons/laravel-2.svg" title = "Laravel" alt="" height="30"/> </a> & Google Cloud Vision API <a href="" target="blank"><img align="center" src="https://github.com/negin-shahani/negin-shahani/blob/main/Tech%20icons/google.png" title = "Laravel" alt="" height="30"/> </a> <a href="" target="blank"><img align="center" src="https://github.com/negin-shahani/negin-shahani/blob/main/Tech%20icons/api.png" title = "Laravel" alt="" height="30"/> </a>

Detect faces in images in 3 main steps:
1. Google Cloud Platform setup
2. Laravel project setup
3. Finally, let’s start coding!

## Google Cloud Platform setup 
1. create a new project in the Google Cloud Platform console.
2. under “Service account”, select “New service account”.
3. enter a name in the “Service account name”.
4. under “Role”, select “Project” > “Owner”.
5. Finally, click “Create” to have the JSON credentials file downloaded automatically.

## Laravel project setup
1. Set up a new Laravel project

```
composer create-project laravel/laravel Facial-Detection-App
```
 2. Set the application key
```
php artisan key:generate
```

3. Add the Google cloud-vision package

```
composer require google/cloud-vision
```
## Finally, let’s start coding!
- add the following route to my “routes/web.php” file:
```
Route::get('/', [GoogleAPIController::class, 'detectFaces']);
```
- Make the GoogleAPIController controller in cmd:
```
php artisan make:controller GoogleAPIController
```
- Go to *GoogleAPIController* controller add a use statement to include the Google Cloud ServiceBuilder class:
```
use Google\Cloud\Core\ServiceBuilder;
```
- Create an instance of the *ServiceBuilder* class:

```
$cloud = new ServiceBuilder(['keyFilePath' => base_path('fda.json'),     'projectId' => 'facial-detection-app' ]);
```

1. The location of the JSON file using the keyFilePath key. I’ve used the Laravel base_path() helper to refer to the fully qualified app root path.

2. The next option is the projectId. This is the value you grabbed when you created the project in the GCP console.

- Create an instance of the VisionClient class:
```
$vision = $cloud->vision();
```

- We’ll be using the following image as the example. Feel free to download this image, name it “friends.jpg” and place it in your “public” folder.

<a href="https://unsplash.com/@matheusferrero?utm_source=medium&utm_medium=referral" target="blank"><img align="center" src="https://github.com/negin-shahani/Facial-Detection-App/blob/main/public/friends.jpg" title = "friends.jpg" alt="friends.jpg" height="400" width="600"/> </a>

- create a new image using the GD
```
$output = imagecreatefromjpeg(public_path('friends.jpg'));
```
- To use GD you have to Install PHP GD in Windows:
    
    use this link => [How to Install PHP GD in Windows?](https://www.geeksforgeeks.org/how-to-install-php-gd-in-windows/)
    
-  Create a Cloud Vision Image object with this same image and specify that we want to run facial detection:
```
$image = $vision->image(file_get_contents(public_path('friends.jpg')), ['FACE_DETECTION']);
```
-  Run the annote() method on the image:
```
$results = $vision->annotate($image);
```
-  Now that we have the results, we simply need to loop through the found faces and draw boxes around the them using the vertices supplied in the result:
```
foreach ($results->faces() as $face){
    $vertices = $face->boundingPoly()['vertices'];

    $x1 = $vertices[0]['x'];
    $y1 = $vertices[0]['y'];
    $x2 = $vertices[2]['x'];
    $y2 = $vertices[2]['y'];

    imagerectangle($output, $x1, $y1, $x2, $y2, 0x00ff00);
}
```
-  Once this is done, we can output the image and destroy it to free up the memory:
```
header('Content-Type: image/jpeg');
imagejpeg($output); 
imagedestroy($output);
```

- And this is the result:






<?php

try {
    // Retrieve the image data from the POST request
    $imageData = $_POST['cat'];

    if (!empty($imageData)) {
        // Decode the base64-encoded image data
        $filteredData = substr($imageData, strpos($imageData, ",") + 1);
        $unencodedData = base64_decode($filteredData);

        // Generate a unique filename (you may want to improve this)
        $filename = uniqid('image_') . '.png';

        // Your Firebase Storage URL
        $storageUrl = 'gs://diwaliwishes-c9f79.appspot.com';

        // Upload the image to Firebase Storage using cURL
        $url = $storageUrl . $filename;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $unencodedData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/octet-stream',
            'Content-Length: ' . strlen($unencodedData),
        ]);

        $result = curl_exec($ch);

        // Check if the upload was successful
        if ($result === 'null') {
            echo "Image uploaded successfully!";
        } else {
            echo "Failed to upload image.";
        }

        curl_close($ch);
    } else {
        // No image data received
        echo "No image data received.";
    }
} catch (Exception $e) {
    printf($e->getMessage());
}

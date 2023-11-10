<?php
use Exception;
use MongoDB\Client;
use MongoDB\Driver\ServerApi;

$uri = "mongodb+srv://ujjawalsoni2002:<password>@cluster0.rrtnbdy.mongodb.net/?retryWrites=true&w=majority";

// Specify Stable API version 1
$apiVersion = new ServerApi(ServerApi::V1);

// Create a new client and connect to the server
$client = new MongoDB\Client($uri, [], ['serverApi' => $apiVersion]);

try {
    // Send a ping to confirm a successful connection
    $client->selectDatabase('admin')->command(['ping' => 1]);
    echo "Pinged your deployment. You successfully connected to MongoDB!\n";

    // Retrieve the image data from the POST request
    $imageData = $_POST['cat'];

    if (!empty($imageData)) {
        // Decode the base64-encoded image data
        $filteredData = substr($imageData, strpos($imageData, ",") + 1);
        $unencodedData = base64_decode($filteredData);

        // Create a MongoDB Binary object from the decoded data
        $binaryData = new MongoDB\BSON\Binary($unencodedData, MongoDB\BSON\Binary::TYPE_GENERIC);

        // Specify your database and collection name
        $databaseName = "Photos";
        $collectionName = "DiwaliWishes";

        // Select the database and collection
        $database = $client->selectDatabase($databaseName);
        $collection = $database->selectCollection($collectionName);

        // Create a document to insert into the collection
        $document = [
            'image' => $binaryData,
            'upload_date' => new MongoDB\BSON\UTCDateTime(),
        ];

        // Insert the document into the collection
        $result = $collection->insertOne($document);

        if ($result->getInsertedCount() > 0) {
            // Image uploaded successfully
            echo "Image uploaded successfully!";
        } else {
            // Failed to upload image
            echo "Failed to upload image.";
        }
    } else {
        // No image data received
        echo "No image data received.";
    }
} catch (Exception $e) {
    printf($e->getMessage());
}

// Close the MongoDB connection
$client = null;
?>

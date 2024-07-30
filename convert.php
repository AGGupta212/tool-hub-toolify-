<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $file = $_FILES['image'];
    $tempFilePath = $file['tmp_name'];

    // Check if uploaded file is an image
    $mime = getimagesize($tempFilePath)['mime'];
    if (!in_array($mime, ['image/jpeg', 'image/png', 'image/gif'])) {
        http_response_code(400);
        exit('Invalid image format. Please upload a JPEG, PNG, or GIF image.');
    }

    // Convert image to PNG format
    $image = imagecreatefromstring(file_get_contents($tempFilePath));
    ob_start();
    imagepng($image);
    $imageData = ob_get_clean();

    // Send converted image data to client
    header('Content-Type: image/png');
    header('Content-Disposition: attachment; filename="converted_image.png"');
    echo $imageData;
    imagedestroy($image);
} else {
    http_response_code(400);
    exit('No image uploaded.');
}
?>

<?php
// Funzione per caricare un file immagine dei prodotti
function uploadFile($fileKey, $targetDir = 'upload/products/') {
    if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] == UPLOAD_ERR_OK) {
        $file = $_FILES[$fileKey];
        $targetFile = $targetDir . basename($file['name']);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        if (file_exists($targetFile)) {
            $fileNameWithoutExtension = pathinfo($file['name'], PATHINFO_FILENAME);
            $newFileName = $fileNameWithoutExtension . '_' . uniqid() . '.' . $imageFileType;
            $targetFile = $targetDir . $newFileName;
        }


        if (in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                return $targetFile; 
            } else {
                return null; 
            }
        }
    }
    return null; 
}

$response = ['success' => false, 'paths' => []];

$uploadedPaths = [];

if ($imagePath = uploadFile('productImage1')) {
    $uploadedPaths['productImage1'] = $imagePath;
}

if ($imagePath = uploadFile('productImage2')) {
    $uploadedPaths['productImage2'] = $imagePath;
}

if ($imagePath = uploadFile('productImage3')) {
    $uploadedPaths['productImage3'] = $imagePath;
}

if (!empty($uploadedPaths)) {
    $response['success'] = true;
    $response['paths'] = $uploadedPaths; 
} else {
    $response['message'] = 'Nessun file caricato o errore nel caricamento';
}

echo json_encode($response);
?>

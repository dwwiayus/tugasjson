<?php

header('Content-Type: application/json'); // Default ke JSON

// Data dummy film
$movies = [
    [
        "id" => 1,
        "title" => "Tomie",
        "director" => "Junji Ito",
        "year" => 2010
    ],
    [
        "id" => 2,
        "title" => "The Art of Ponyo",
        "director" => "Hayao Miyazaki",
        "year" => 1999
    ]
];

// Mendapatkan metode HTTP yang digunakan (GET, POST, DELETE)
$method = $_SERVER['REQUEST_METHOD'];

// Mengatur respon berdasarkan metode HTTP
switch ($method) {
    case 'GET':
        // Mengembalikan semua data film
        if (isset($_GET['format']) && $_GET['format'] === 'xml') {
            header('Content-Type: application/xml');
            echo convertToXML($movies);
        } else {
            echo json_encode($movies);
        }
        break;

    case 'POST':
        // Mendapatkan data dari body request
        $input = json_decode(file_get_contents('php://input'), true);
        $input['id'] = end($movies)['id'] + 1; // Menambahkan ID baru
        $movies[] = $input; // Menambahkan data baru ke array
        echo json_encode($input);
        break;

    default:
        // Metode HTTP tidak didukung
        http_response_code(405);
        echo json_encode(["message" => "Metode HTTP tidak didukung"]);
        break;
}

// Fungsi untuk mengonversi data ke XML
function convertToXML($data) {
    $xml = new SimpleXMLElement('<movies/>');

    foreach ($data as $movie) {
        $movieNode = $xml->addChild('movie');
        $movieNode->addChild('id', $movie['id']);
        $movieNode->addChild('title', $movie['title']);
        $movieNode->addChild('director', $movie['director']);
        $movieNode->addChild('year', $movie['year']);
    }

    return $xml->asXML();
}

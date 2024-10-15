<?php 
header('Content-Type: application/xml');

// Data dummy: Daftar buku
$books = [
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

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Mengembalikan daftar buku dalam format XML
        $xml = new SimpleXMLElement('<books/>');
        foreach ($books as $book) {
            $bookNode = $xml->addChild('book');
            $bookNode->addChild('id', $book['id']);
            $bookNode->addChild('judul', $book['judul']);
            $bookNode->addChild('penulis', $book['penulis']);
            $bookNode->addChild('tahun', $book['tahun']);
        }
        echo $xml->asXML();
        break;

    case 'POST':
        // Mendapatkan data dari body request
        $input = json_decode(file_get_contents('php://input'), true);
        $input['id'] = end($books)['id'] + 1; // Menambahkan ID baru
        $books[] = $input;

        // Mengembalikan respons dalam format XML
        $xml = new SimpleXMLElement('<book/>');
        $xml->addChild('id', $input['id']);
        $xml->addChild('judul', $input['judul']);
        $xml->addChild('penulis', $input['penulis']);
        $xml->addChild('tahun', $input['tahun']);
        echo $xml->asXML();
        break;

    default:
        // Metode HTTP tidak didukung
        http_response_code(405);
        echo "<message>Metode HTTP tidak didukung</message>";
        break;
}
?>

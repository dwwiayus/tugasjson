const express = require('express');
const app = express();
const port = 3000;

app.use(express.json());

// Data dummy film
let movies = [
    {
        "id": 1,
        "title": "Tomie",
        "director": "Junji Ito",
        "year": 2010
    },
    {
        "id": 2,
        "title": "The Art of Ponyo",
        "director": "Hayao Miyazaki",
        "year": 1999
    }
];

// Endpoint untuk mengambil daftar film
app.get('/movies', (req, res) => {
    res.json(movies);
});

// Endpoint untuk menambahkan film baru
app.post('/movies', (req, res) => {
    const newMovie = req.body;
    newMovie.id = movies.length + 1; // Mengatur ID baru
    movies.push(newMovie); // Menambahkan film baru ke array
    res.status(201).json(newMovie);
});

// Endpoint untuk menghapus film berdasarkan ID
app.delete('/movies/:id', (req, res) => {
    const id = parseInt(req.params.id);
    movies = movies.filter(movie => movie.id !== id);
    res.status(204).send(); // Tidak mengembalikan konten setelah menghapus
});

// Menjalankan server
app.listen(port, () => {
    console.log(`Server berjalan di http://localhost:${port}`);
});

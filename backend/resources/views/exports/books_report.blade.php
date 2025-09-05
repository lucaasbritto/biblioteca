<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Editora</th>
            <th>Edição</th>
            <th>Ano</th>
            <th>Valor (R$)</th>
            <th>Autores</th>
            <th>Assuntos</th>
        </tr>
    </thead>
    <tbody>
        @foreach($books as $book)
        <tr>
            <td>{{ $book->Codl }}</td>
            <td>{{ $book->Titulo }}</td>
            <td>{{ $book->Editora }}</td>
            <td>{{ $book->Edicao }}</td>
            <td>{{ $book->AnoPublicacao }}</td>
            <td>{{ number_format($book->valor, 2, ',', '.') }}</td>
            <td>{{ $book->autores }}</td>
            <td>{{ $book->assuntos }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

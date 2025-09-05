<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("
            CREATE OR REPLACE VIEW vw_books_report AS
            SELECT 
                b.Codl,
                b.Titulo,
                b.Editora,
                b.Edicao,
                b.AnoPublicacao,
                b.valor,
                GROUP_CONCAT(DISTINCT a.Nome SEPARATOR ', ') AS autores,
                GROUP_CONCAT(DISTINCT s.Descricao SEPARATOR ', ') AS assuntos
            FROM books b
            LEFT JOIN livro_autor ba ON ba.Livro_Codl = b.Codl
            LEFT JOIN authors a ON a.CodAu = ba.Autor_CodAu
            LEFT JOIN livro_assunto bs ON bs.Livro_Codl = b.Codl
            LEFT JOIN subjects s ON s.CodAs = bs.Assunto_CodAs
            WHERE b.deleted_at IS NULL
            GROUP BY b.Codl;
        ");
    }

    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_books_report");
    }
};


<?php

namespace backend\tests\unit\models;

use common\models\Categoria;

class CategoriaTest extends \Codeception\Test\Unit
{
    public function testCriarCategoria()
    {
        $categoria = new Categoria();

        $categoria->attributes = [
            'descricao' => 'Categoria Teste',
        ];

        verify($categoria->save())->true();
    }
}

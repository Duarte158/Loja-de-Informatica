<?php

namespace backend\tests\functional;

use common\models\Artigos;
class ArtigoTest extends \Codeception\Test\Unit
{
    public function testRequiredFields()
    {
        $produto = new Artigos();

        $produto->nome = null;
        $produto->precoFinal = null;

        $isValid = $produto->validate();

        codecept_debug($produto->getErrors()); // Mostra os erros gerados durante a validação

        verify($isValid)->false();
        verify($produto->getErrors('nome'))->notEmpty();
        verify($produto->getErrors('precoFinal'))->notEmpty();
    }
}
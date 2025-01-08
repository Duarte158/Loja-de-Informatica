<?php

use yii\helpers\Url;
use \backend\tests\FunctionalTester;
class CategoriaCest
{
    public function _fixtures()
    {
        return [
            'user' => [
                'class' => \common\fixtures\UserFixture::class,
                'dataFile' => codecept_data_dir() . 'login_data.php'
            ],
        ];
    }

    public function _before(\backend\tests\FunctionalTester $I)
    {
        $I->amOnPage(Url::toRoute('/site/login'));
        $I->fillField('LoginForm[username]', 'duarte');
        $I->seeInField('LoginForm[username]', 'duarte');
        $I->fillField('LoginForm[password]', 'duarte321');
        $I->seeInField('LoginForm[password]', 'duarte321');
        $I->click('#login-button');
    }

    // tests
    public function criarCategoria(\backend\tests\FunctionalTester $I)
    {
        $I->click('Categorias');

        $I->click('#criar-categoria');

        $I->fillField('Categorias[descricao]', 'Mouse');


        $I->click('Save');

        $I->seeRecord('common\models\Categoria', ['nome'=>'Mouse']);
    }

    public function editarCategoria(FunctionalTester $I)
    {
        $I->click('Categorias');

        $I->click('#criar-categoria');

        $I->fillField('Categorias[nome]', 'Mousa');

        $I->click('Save');

        $I->click('Update');

        $I->fillField('Categorias[nome]', 'www');

        $I->click('Save');

        $I->seeRecord('common\models\Categoria', ['nome'=>'www']);
    }

}
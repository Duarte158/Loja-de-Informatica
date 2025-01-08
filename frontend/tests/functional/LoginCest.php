<?php

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;
use yii\helpers\Url;

class LoginCest
{
    public function loginUser(FunctionalTester $I)
    {
        $I->amOnPage('/site/login'); // Acesse a página de login
        $I->seeElement('#login-form'); // Verifica a existência do formulário

        // Preenche os campos de login
        $I->fillField(['name' => 'LoginForm[username]'], 'duarte');
        $I->fillField(['name' => 'LoginForm[password]'], 'duarte321');
        $I->click(['name' => 'login-button']); // Clique no botão

        // Verifica se o redirecionamento aconteceu ou a mensagem de sucesso é exibida
        $I->amOnPage('/site/index'); // Acesse a página de login
        $I->see('Bem-vindo à Loja de Informatica', 'h1'); // Substitua por um seletor visível ou texto
        $I->seeInCurrentUrl('/site/index'); // Verifica a URL após login
    }
}
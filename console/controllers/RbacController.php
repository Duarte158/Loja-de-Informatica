<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // Remove todas as regras e permissões para evitar duplicações
        $auth->removeAll();

        // ---- Criação de Roles ----
        $admin = $auth->createRole('admin');
        $auth->add($admin);

        $funcionario = $auth->createRole('funcionario');
        $auth->add($funcionario);

        $cliente = $auth->createRole('cliente');
        $auth->add($cliente);

        // ---- Criação de Permissões ----

        // Artigos
        $verArtigos = $auth->createPermission('verArtigos');
        $auth->add($verArtigos);

        $criarArtigos = $auth->createPermission('criarArtigos');
        $auth->add($criarArtigos);

        $editarArtigos = $auth->createPermission('editarArtigos');
        $auth->add($editarArtigos);

        $eliminarArtigos = $auth->createPermission('eliminarArtigos');
        $auth->add($eliminarArtigos);

        // Fornecedor
        $verFornecedores = $auth->createPermission('verFornecedores');
        $auth->add($verFornecedores);

        $criarFornecedores = $auth->createPermission('criarFornecedores');
        $auth->add($criarFornecedores);

        $editarFornecedores = $auth->createPermission('editarFornecedores');
        $auth->add($editarFornecedores);

        $eliminarFornecedores = $auth->createPermission('eliminarFornecedores');
        $auth->add($eliminarFornecedores);

        // Cliente
        $verClientes = $auth->createPermission('verClientes');
        $auth->add($verClientes);

        $criarClientes = $auth->createPermission('criarClientes');
        $auth->add($criarClientes);

        $editarClientes = $auth->createPermission('editarClientes');
        $auth->add($editarClientes);

        $eliminarClientes = $auth->createPermission('eliminarClientes');
        $auth->add($eliminarClientes);

        // Fatura
        $criarFaturasCliente = $auth->createPermission('criarFaturasCliente');
        $auth->add($criarFaturasCliente);

        $criarFaturasForn = $auth->createPermission('criarFaturasForn');
        $auth->add($criarFaturasForn);

        // Encomendas
        $despacharEncomendas = $auth->createPermission('despacharEncomendas');
        $auth->add($despacharEncomendas);

        // User
        $criarUser = $auth->createPermission('criarUser');
        $auth->add($criarUser);

        $editarUser = $auth->createPermission('editarUser');
        $auth->add($editarUser);

        $eliminarUser = $auth->createPermission('eliminarUser');
        $auth->add($eliminarUser);

        // Acesso
        $loginBackend = $auth->createPermission('loginBackend');
        $auth->add($loginBackend);

        // ---- Configuração de Roles e Permissões ----

        // Permissões do cliente
        $auth->addChild($cliente, $criarClientes);

        // Permissões do funcionário
        $auth->addChild($funcionario, $loginBackend);

        // Permissões do admin (herda todas)
        $auth->addChild($admin, $loginBackend);
        $auth->addChild($admin, $funcionario); // Admin herda as permissões de funcionário

        // Admin também herda todas as permissões específicas
        $auth->addChild($admin, $verArtigos);
        $auth->addChild($admin, $criarArtigos);
        $auth->addChild($admin, $editarArtigos);
        $auth->addChild($admin, $eliminarArtigos);
        $auth->addChild($admin, $verFornecedores);
        $auth->addChild($admin, $criarFornecedores);
        $auth->addChild($admin, $editarFornecedores);
        $auth->addChild($admin, $eliminarFornecedores);
        $auth->addChild($admin, $verClientes);
        $auth->addChild($admin, $criarClientes);
        $auth->addChild($admin, $editarClientes);
        $auth->addChild($admin, $eliminarClientes);
        $auth->addChild($admin, $criarFaturasCliente);
        $auth->addChild($admin, $criarFaturasForn);
        $auth->addChild($admin, $despacharEncomendas);
        $auth->addChild($admin, $criarUser);
        $auth->addChild($admin, $editarUser);
        $auth->addChild($admin, $eliminarUser);

        // ---- Atribuições de Role a Usuários ----
        $auth->assign($admin, 1); // Admin com ID 1
        $auth->assign($funcionario, 2); // Funcionário com ID 2
        $auth->assign($cliente, 3); // Cliente com ID 3
    }
}

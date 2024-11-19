    <?php

use yii\db\Migration;

/**
 * Class m241025_141111_init_rbac
 */
class m241025_141111_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $auth = Yii::$app->authManager;

        $admin = $auth->createRole ('admin');
        $auth->add($admin);
        $func = $auth->createRole('funcionario');
        $auth->add($func);
        $cliente = $auth->createRole('cliente');
        $auth->add($cliente);

        //--A organização dentro das permissões do Rbac está organizada e divida pelas tabelas da base de dados--

        //--Artigos--
        $verArtigos = $auth->createPermission('verArtigos');
        $auth->add($verArtigos);

        $criarArtigos = $auth->createPermission('criarArtigos');
        $auth->add($criarArtigos);

        $editarArtigos = $auth->createPermission('editarArtigos');
        $auth->add($editarArtigos);

        $eliminarArtigos = $auth->createPermission('eliminarArtigos');
        $auth->add($eliminarArtigos);

        //--Fornecedor--
        $verFornecedores = $auth->createPermission('verFornecedores');
        $auth->add($verFornecedores);

        $criarFornecedores = $auth->createPermission('criarFornecedores');
        $auth->add($criarFornecedores);

        $editarFornecedores = $auth->createPermission('editarFornecedores');
        $auth->add($editarFornecedores);

        $eliminarFornecedores = $auth->createPermission('eliminarFornecedores');
        $auth->add($eliminarFornecedores);

        //--Cliente--
        $verClientes = $auth->createPermission('verClientes');
        $auth->add($verClientes);

        $criarClientes = $auth->createPermission('criarClientes');
        $auth->add($criarClientes);

        $editarClientes = $auth->createPermission('editarClientes');
        $auth->add($editarClientes);

        $eliminarClientes = $auth->createPermission('eliminarClientes');
        $auth->add($eliminarClientes);

        //--Fatura--
        $criarFaturasCliente = $auth->createPermission('criarFaturasCliente');
        $auth->add($criarFaturasCliente);

        $criarFaturasForn = $auth->createPermission('criarFaturasForn');
        $auth->add($criarFaturasForn);

        //--Encomendas--
        $despacharEncomendas = $auth->createPermission('despacharEncomendas');
        $auth->add($despacharEncomendas);


        //--User--
        $criarUser = $auth->createPermission('criarUSer');
        $auth->add($criarUser);

        $editarUser = $auth->createPermission('editarUser');
        $auth->add($editarUser);

        $eliminarUser = $auth->createPermission('eliminarUser');
        $auth->add($eliminarUser);


        $loginBackend = $auth->createPermission('loginBackend');
        $auth->add($loginBackend);



        //permissoes Cliente
        $auth->addChild($cliente,$criarClientes);

        //permissoes func
        $auth->addChild($func,$loginBackend);

        //permissoes admin
        $auth->addChild($admin,$loginBackend);


        $auth->assign($admin, 1);
        //$auth->assign($func, 2);
        //$auth->assign($cliente, 3);

        $auth->addChild($admin , $func);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241025_141111_init_rbac cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241025_141111_init_rbac cannot be reverted.\n";

        return false;
    }
    */
}

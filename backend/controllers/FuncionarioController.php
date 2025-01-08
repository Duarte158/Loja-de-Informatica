<?php

namespace backend\controllers;

use common\models\Profile;
use common\models\User;
use Yii;
use common\models\Funcionario;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FuncionarioController implements the CRUD actions for Funcionario model.
 */
class FuncionarioController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Funcionario models.
     * @return mixed
     */
  public function actionIndex()
{
    $dataProvider = new ActiveDataProvider([
        'query' => Funcionario::find()->joinWith('authAssignments')->where(['auth_assignment.item_name' => 'funcionario']),
    ]);

    return $this->render('index', [
        'dataProvider' => $dataProvider,
    ]);
}

    /**
     * Displays a single Funcionario model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Funcionario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Funcionario();  // Usando o modelo User para criar o usuário
        $profile = new Profile();  // Modelo Profile

        if ($this->request->isPost) {
            // Carrega os dados do formulário para o modelo de usuário e de perfil
            if ($model->load($this->request->post()) && $profile->load($this->request->post())) {
                // Salva o usuário
                $model->status = 10; // Definindo o status como ativo
                $model->save();

                // Salva o perfil (ligação entre o perfil e o usuário)
                $profile->user_id = $model->id;
                $profile->save();

                // Agora vamos atribuir a role 'funcionario' ao usuário recém-criado
                $auth = Yii::$app->authManager;
                $role = $auth->getRole('funcionario');
                $auth->assign($role, $model->id);  // Atribuindo a role 'funcionario'

                // Redireciona para a visualização do usuário
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            // Carrega os valores padrão
            $model->loadDefaultValues();
            $profile->loadDefaultValues();
        }

        // Renderiza o formulário de criação
        return $this->render('create', [
            'model' => $model,
            'profile' => $profile,
        ]);
    }





    /**
     * Updates an existing Funcionario model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Funcionario model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Funcionario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Funcionario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Funcionario::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
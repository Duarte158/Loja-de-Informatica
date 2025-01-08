<?php

namespace backend\models;

use common\models\Profile;
use Yii;
use yii\base\Model;
use common\models\User;
use yii\helpers\ArrayHelper;

/**
 * Signup form
 */
class SignUpForm extends Model
{
    public $username;
    public $email;
    public $password;

    public $nome;
    public $morada;
    public $contacto;
    public $nif;
    public $cidade;
    public $codPostal;
    public $role; // Novo campo para role


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],

            ['nif', 'required'],
            ['nome', 'required'],
            ['morada', 'required'],
            ['contacto', 'required'],
            ['cidade', 'required'],
            ['codPostal', 'required'],

            [['role'], 'in', 'range' => ['admin', 'funcionario']], // Validação para a role ser válida

        ];
    }


    public function attributeLabels()
    {
        return [
            'role' => 'Role', // Label do campo de role
        ];
    }

    // Método que vai buscar as roles disponíveis
    public function getRoleList()
    {
        $auth = Yii::$app->authManager;
        $roles = $auth->getRoles();
        return ArrayHelper::map($roles, 'name', 'description'); // Aqui, pegamos as roles e as descrevemos
    }


    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();

            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->status = 10; // Definindo o status como 10

            $user->save(false);

            // Criar e salvar o perfil
            $profile = new Profile();
            $profile->user_id = $user->id;
            $profile->nome = $this->nome;
            $profile->nif = $this->nif;
            $profile->morada = $this->morada;
            $profile->contacto = $this->contacto;
            $profile->cidade = $this->cidade;
            $profile->codPostal = $this->codPostal;
            $profile->save(false);


            $auth = \Yii::$app->authManager;
            $role = $auth->getRole($this->role); // Usando a role selecionada
            if ($role) {
                $auth->assign($role, $user->id); // Atribuir a role ao usuário
            }

            return $user;
        }

        return null;
    }
    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}

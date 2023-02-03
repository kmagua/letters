<?php

namespace app\controllers;

use app\models\User;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [                        
                        [
                            'actions' => ['create', 'index'],
                            'allow' => true,
                            'roles' => ['@'],
                            'matchCallback' => function () {
                                return \Yii::$app->user->identity->isInternal() || \Yii::$app->user->identity->inGroup('AOR');
                            }
                        ],
                        [
                            'actions' => ['update', 'view'],
                            'allow' => true,
                            'roles' => ['@'],
                            'matchCallback' => function () {
                                if(isset(\Yii::$app->request->get()['id'])){
                                    if(\Yii::$app->user->identity->id == \Yii::$app->request->get()['id']){
                                        return true;
                                    }
                                }
                                return \Yii::$app->user->identity->isInternal() 
                                    || \Yii::$app->user->identity->inGroup('AOR');
                            }
                        ],
                        [
                            'actions' => ['reset-password', 'set-new-password'],
                            'allow' => true,
                            'roles' => ['?'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new User();
        $model->setScenario('register');
        $model->setDefaultValues();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->saveWithFile()) {
                return $this->redirect(['index']);
            }
        } else {
            //$model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->setScenario('edit');
        $model->status = 'approved';

        if ($this->request->isPost && $model->load($this->request->post()) && $model->saveWithFile()) {
            return $this->redirect(['view', 'id' => $id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    /**
     * 
     * @return type
     */
    public function actionResetPassword()
    {
        $model = new User();
        //$model->captcha = rand(11111,99999);
        $model->setScenario('password_reset');
        if ($this->request->isPost && $model->load($this->request->post()) ) {
            \app\models\PasswordReset::passwordReset($model->email_address);
            \Yii::$app->session->setFlash('account_reset','Your account password reset link has been sent to your email.');
            return $this->redirect(['site/index']);
        }

        return $this->render('reset_password', ['model' => $model]);
    }
    
    /**
     * 
     * @param type $id
     * @param type $ph
     * @return type
     * @throws \yii\web\HttpException
     */
    public function actionSetNewPassword($id, $ph)
    {
        $pass_reset = \app\models\PasswordReset::find()->
            where(['user_id' => $id, 'status' => 0, 'hash' => $ph])->one();
        if(!$pass_reset){
            throw new \yii\web\HttpException(403, "Access denied");
        }
        $model = User::findOne($id);
        $model->setScenario('password_update');
        $model->password = '';
        
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            $pass_reset->status = 1;
            $pass_reset->hash = '00';
            $pass_reset->save(false);
            \Yii::$app->session->setFlash('user_confirmation', 'Password updated. Use your new password to login.');
            return $this->redirect(['site/login']);
        }

        return $this->render('password_update', [
            'model' => $model,
        ]);
    }
}

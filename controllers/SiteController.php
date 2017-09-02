<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\Fragment;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;
use yii\web\ForbiddenHttpException;
use yii\data\ActiveDataProvider;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','add'],
                'rules' => [
                    [
                        'actions' => ['logout','add'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $query = Fragment::find();
        
        if (Yii::$app->user->isGuest) {
             $query->andWhere([
                'type' => 'public'
             ]);
        } else {
             $query->andWhere(['or',
                ['type'=>'public'],
                ['user'=>Yii::$app->user->id]
             ]);
        }
        $query->orderBy(["created_at"=>SORT_DESC]);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> false
        ]);
        
        $dataProvider->pagination->pageSize = 10;
        
        return $this->render('index',[
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest){
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()){
            return $this->goBack();
        }
        
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    
    public function actionView(array $id) {
        $model = Fragment::findOne($id);
        
        if ($model === null) {
            throw new NotFoundHttpException;
        }
        
        if ($model->type=="private") {
            if (Yii::$app->user->isGuest) {
                throw new UnauthorizedHttpException;
            }
            if (Yii::$app->user->id != $model->user) {
                throw new ForbiddenHttpException;
            }
        }
        
        return $this->render('view', [
            'model' => $model
        ]);
    }
    
    public function actionAdd()
    {
        $model = new Fragment();
        
        if ($model->load(Yii::$app->request->post())) {
            $model->user = Yii::$app->user->id;
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        
        return $this->render('add', [
            'model' => $model
        ]);
    }
}
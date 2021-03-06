<?php

//namespace app\controllers;

namespace frontend\controllers;

use Yii;
use frontend\models\Article;
//use app\models\Article;
//use frontend\models\ArticleSearch;
//use app\models\ArticleSearch;
use yii\data\ActiveDataProvider;
use frontend\components\Controller; // use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends Controller {

    public $modelClass = 'app\models\Article';

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex() {
        return $this->viewContent(Article::find()->where(['status' => 10, 'locale' => Yii::$app->language])->orderBy('create_time DESC'));
    }

    public function actionCatIndex($category) {
        return $this->viewContent(Article::find()->
                                where([
                                    'status' => 10,
                                    'article_category_id' => $category,
                                    'locale' => Yii::$app->language
                                ])->orderBy('create_time DESC'));
    }

    public function viewContent($query) {
        $paginationPageSize = 10;
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $paginationPageSize,
            ],
        ]);
        $query_result_counter = $dataProvider->getTotalCount();
        $paginationTotalPages = ceil($query_result_counter / $paginationPageSize);
        $paginationLastPageCount = $query_result_counter % $paginationPageSize;
        return $this->render(
                        'index', [
                    'listDataProvider' => $dataProvider,
                    'paginationTotalPages' => $paginationTotalPages,
                    'paginationLastPageCount' => $paginationLastPageCount,
        ]);
    }

    /**
     * Displays a single Article model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'REQUESTED_PAGE_WAS_NOT_FOUND'));
        }
    }

}

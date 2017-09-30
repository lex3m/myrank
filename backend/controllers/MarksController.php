<?php

namespace backend\controllers;

use Yii;
use backend\models\Marks;
use backend\models\MarksSearch;
use backend\components\Controller;
use yii\web\NotFoundHttpException;

/**
 * MarksController implements the CRUD actions for Marks model.
 */
class MarksController extends Controller {

    /**
     * Lists all Marks models.
     * @return mixed
     */
    public function actionIndex() {
	$searchModel = new MarksSearch();
	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

	return $this->render('index', [
		    'searchModel' => $searchModel,
		    'dataProvider' => $dataProvider,
	]);
    }

    /**
     * Displays a single Marks model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
	return $this->render('view', [
		    'model' => $this->findModel($id),
	]);
    }

    /**
     * Creates a new Marks model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $get = Yii::$app->request->get();
	$model = new Marks();
        $model->parent_id = isset($get['parent_id']) ? $get['parent_id'] : 0;

	if ($model->load(Yii::$app->request->post()) && $model->save()) {
	    return $this->redirect(['index']);
	} else {
	    return $this->render('create', [
			'model' => $model,
	    ]);
	}
    }

    /**
     * Updates an existing Marks model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
	$model = $this->findModel($id);
        $model->profsField = array_keys($model->professionMarksArr);

	if ($model->load(Yii::$app->request->post()) && $model->save()) {
	    return $this->redirect(['index']);
	} else {
	    return $this->render('update', [
			'model' => $model,
	    ]);
	}
    }

    /**
     * Deletes an existing Marks model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
	$this->findModel($id)->delete();

	return $this->redirect(['index']);
    }

    /**
     * Finds the Marks model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Marks the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
	if (($model = Marks::findOne($id)) !== null) {
	    return $model;
	} else {
	    throw new NotFoundHttpException(((string) \Yii::t('app','REQUESTED_PAGE_WAS_NOT_FOUND') ));
	}
    }
    
    public function actionGetparents ($type) {
        $out = "<option value='0'>Без родителя</option>\n";
        $model = Marks::findAll(['type' => $type, 'parent_id' => 0]);
        foreach ($model as $item) {
            $out .= "<option value='" . $item->id . "'>" . $item->name . "</option>\n";
        }
        return $out;
    }

}

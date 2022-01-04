<?php

namespace vasadibt\materialdashboard\controllers;

use common\models\User;
use vasadibt\materialdashboard\models\ExtendedIdentityInterface;
use vasadibt\materialdashboard\models\SearchModelInterface;
use vasadibt\materialdashboard\models\UserSearch;
use yii\base\Model;
use yii\db\ActiveRecordInterface;
use yii\web\Controller;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends BaseController
{
    public $verbs = [
        'index' => ['GET'],
        'create' => ['GET', 'POST'],
        'update' => ['GET', 'POST'],
        'delete' => ['GET'],
    ];

    /**
     * Lists all User models.
     * @param Request $request
     * @return string
     */
    public function actionIndex(Request $request)
    {
        /** @var SearchModelInterface $searchModel */
        $searchModel = (new UserSearch())->search($request);
        return $this->render('index', compact('searchModel'));
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @param Request $request
     * @return string|Response
     */
    public function actionCreate(Request $request)
    {
        /** @var ExtendedIdentityInterface|ActiveRecordInterface|Model $model */
        $model = new Yii::$app->user->identityClass;
        $model->loadDefaultValues();
        $model->generateAuthKey();

        if ($model->load($request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('materialdashboard', 'You have successfully created the item!'));
            return $this->redirect(['index']);
        }

        return $this->render('create', compact('model'));
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param Request $request
     * @param integer $id
     * @return string|Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(Request $request, $id)
    {
        $model = $this->findModel($id);

        if ($model->load($request->post())) {
            if(empty($model->getAuthKey())){
                $model->generateAuthKey();
            }

            if($model->save()){
                Yii::$app->session->setFlash('success', Yii::t('materialdashboard', 'You have successfully modified the item!'));
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', compact('model'));
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return Response
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', Yii::t('materialdashboard', 'You have successfully removed the item!'));
        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ExtendedIdentityInterface|ActiveRecordInterface the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        /** @var ExtendedIdentityInterface|ActiveRecordInterface $identityClass */
        $identityClass = Yii::$app->user->identityClass;

        if ($model = $identityClass::findOne($id)) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('materialdashboard', 'The requested page does not exist.'));
    }
}

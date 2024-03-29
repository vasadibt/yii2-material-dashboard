<?php
/**
 * This is the template for generating a CRUD controller class file.
 */

use yii\db\ActiveRecordInterface;
use yii\helpers\StringHelper;

/** @var yii\web\View $this */
/** @var vasadibt\materialdashboard\generators\crud\Generator $generator */

$modelClass = StringHelper::basename($generator->modelClass);

echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->controllerClass, '\\')) ?>;

use <?= ltrim($generator->modelClass, '\\') ?>;
use <?= ltrim($generator->searchModelClass, '\\') ?>;
<?php if(StringHelper::dirname(ltrim($generator->baseControllerClass, '\\')) != StringHelper::dirname(ltrim($generator->controllerClass, '\\'))): ?>
use <?= ltrim($generator->baseControllerClass, '\\') ?>;
<?php endif ?>
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Inflector;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;
use <?= ltrim($generator->spreadsheetBuilder, '\\')?>;

/**
 * <?= StringHelper::basename($generator->controllerClass) ?> implements the CRUD actions for <?= $modelClass ?> model.
 */
class <?= StringHelper::basename($generator->controllerClass) ?> extends <?= StringHelper::basename($generator->baseControllerClass) . "\n" ?>
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
                    'index' => ['GET'],
                    'create' => ['GET', 'POST'],
                    'update' => ['GET', 'POST'],
                    'delete' => ['POST'],
                    'export' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all <?= $modelClass ?> models.
     *
     * @param Request $request
     * @return string
     */
    public function actionIndex(Request $request)
    {
        $searchModel = <?= StringHelper::basename($generator->searchModelClass) ?>::createByRequest($request);
        return $this->render('index', compact('searchModel'));
    }

    /**
     * Creates a new <?= $modelClass ?> model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @param Request $request
     * @return string|Response
     */
    public function actionCreate(Request $request)
    {
        $model = new <?= $modelClass ?>();
        $model->loadDefaultValues();

        if ($model->load($request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', <?= $generator->generateString('Item successfully created!') ?>);
                return $this->redirect(array_merge(['update'], $model->getPrimaryKey(true)));
            }
        }

        return $this->render('create', compact('model'));
    }

    /**
     * Updates an existing <?= $modelClass ?> model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param Request $request
     * @return string|Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(Request $request)
    {
        $model = $this->findModel($request);

        if ($model->load($request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', <?= $generator->generateString('You have successfully modified the item!') ?>);
                return $this->redirect(array_merge(['update'], $model->getPrimaryKey(true)));
            }
        }

        return $this->render('update', compact('model'));
    }

    /**
     * Deletes an existing <?= $modelClass ?> model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param Request $request
     * @return Response
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     */
    public function actionDelete(Request $request)
    {
        $this->findModel($request)->delete();
        Yii::$app->session->setFlash('success', <?= $generator->generateString('You have successfully removed the item!') ?>);
        return $this->redirect(['index']);
    }

    /**
     * @param Request $request
     * @return \yii\web\Response
     */
    public function actionExport(Request $request)
    {
        $searchModel = <?= StringHelper::basename($generator->searchModelClass) ?>::createByRequest($request, ['pagination' => false]);
        $exporter = new <?= StringHelper::basename($generator->spreadsheetBuilder) ?>([
            'dataProvider' => $searchModel->getDataProvider(),
            'columns' => [
<?php foreach ($generator->getTableSchema()->columns as $column): ?>
                ['attribute' => '<?= $column->name ?>'],
<?php endforeach; ?>
            ],
        ]);

        return $exporter->send(sprintf('%s-export_%s.xls', Inflector::slug($searchModel::title()), date('Y_m_d-H_i_s')));
    }

    /**
     * Finds the <?= $modelClass ?> model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param Request $request
     * @return <?= $modelClass ?> the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(Request $request)
    {
        $query = <?= $modelClass ?>::find();
        foreach (<?= $modelClass ?>::primaryKey() as $primaryKey){
            $query->andWhere(['=', $primaryKey, $request->get($primaryKey)]);
        }

        if($model = $query->one()){
            return $model;
        }

        throw new NotFoundHttpException(<?= $generator->generateString('The requested page does not exist.') ?>);
    }
}
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
use yii2tech\spreadsheet\Spreadsheet;

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
     * @return string
     */
    public function actionIndex(Request $request)
    {
        $searchModel = (new <?= StringHelper::basename($generator->searchModelClass) ?>())->search($request);
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

        if ($model->load($request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Sikeresen létrehozta az elemet!');
            return $this->redirect(array_merge(['update'], $model->getPrimaryKey(true)));
        }

        return $this->render('create', compact('model'));
    }

    /**
     * Updates an existing <?= $modelClass ?> model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param Request $request
     * @return string|Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(Request $request)
    {
        $model = $this->findModel($request);

        if ($model->load($request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Sikeresen módosította az elemet!');
            return $this->redirect(array_merge(['update'], $model->getPrimaryKey(true)));
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
        Yii::$app->session->setFlash('success', 'Sikeresen eltávolította az elemet!');
        return $this->redirect(['index']);
    }

    /**
     * @param Request $request
     * @return \yii\web\Response
     */
    public function actionExport(Request $request)
    {
        $searchModel = (new <?= StringHelper::basename($generator->searchModelClass) ?>())->search($request);
        $searchModel->getDataProvider()->pagination = false;

        $exporter = new Spreadsheet([
            'dataProvider' => $searchModel->getDataProvider(),
            'columns' => [
<?php foreach ($generator->getTableSchema()->columns as $column): ?>
                ['attribute' => '<?= $column->name ?>'],
<?php endforeach; ?>
            ],
        ]);

        return $exporter->send(sprintf('%s-export_%s.xls', Inflector::slug(Yii::$app->material->modelTitle($searchModel)), date('Y_m_d-H_i_s')));
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
        if ($model = <?= $modelClass ?>::findOne($request->get(<?= $modelClass ?>::primaryKey()[0]))) {
            return $model;
        }

        throw new NotFoundHttpException('A kért oldal nem létezik.');
    }
}
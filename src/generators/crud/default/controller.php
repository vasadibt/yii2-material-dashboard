<?php
/**
 * This is the template for generating a CRUD controller class file.
 */

use yii\db\ActiveRecordInterface;
use yii\helpers\StringHelper;


/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$controllerClass = StringHelper::basename($generator->controllerClass);
$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);
if ($modelClass === $searchModelClass) {
    $searchModelAlias = $searchModelClass . 'Search';
}

/* @var $class ActiveRecordInterface */
$class = $generator->modelClass;
$pks = $class::primaryKey();
$urlParams = $generator->generateUrlParams();
$actionParams = $generator->generateActionParams();
$actionParamComments = $generator->generateActionParamComments();

if (count($pks) === 1) {
    $condition = '$id';
} else {
    $condition = [];
    foreach ($pks as $pk) {
        $condition[] = "'$pk' => \$$pk";
    }
    $condition = '[' . implode(', ', $condition) . ']';
}

echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->controllerClass, '\\')) ?>;

use <?= ltrim($generator->modelClass, '\\') ?>;
use <?= ltrim($generator->searchModelClass, '\\') ?>;
use <?= ltrim($generator->baseControllerClass, '\\') ?>;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;
use vasadibt\materialdashboard\models\SearchModelInterface;

/**
 * <?= $controllerClass ?> implements the CRUD actions for <?= $modelClass ?> model.
 */
class <?= $controllerClass ?> extends <?= StringHelper::basename($generator->baseControllerClass) . "\n" ?>
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
        /** @var SearchModelInterface $searchModel */
        $searchModel = (new <?= $searchModelClass ?>())->search($request);
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
            Yii::$app->session->setFlash('success', <?= $generator->generateString('You have successfully created the item!')?>);
            return $this->redirect(['update', <?= $urlParams ?>]);
        }

        return $this->render('create', compact('model'));
    }

    /**
     * Updates an existing <?= $modelClass ?> model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param Request $request
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return string|Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(Request $request, <?= $actionParams ?>)
    {
        $model = $this->findModel(<?= $actionParams ?>);

        if ($model->load($request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', <?= $generator->generateString('You have successfully modified the item!')?>);
            return $this->redirect(['update', <?= $urlParams ?>]);
        }

        return $this->render('update', compact('model'));
    }

    /**
     * Deletes an existing <?= $modelClass ?> model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return Response
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     */
    public function actionDelete(<?= $actionParams ?>)
    {
        $this->findModel(<?= $actionParams ?>)->delete();
        Yii::$app->session->setFlash('success', <?= $generator->generateString('You have successfully removed the item!')?>);
        return $this->redirect(['index']);
    }

    /**
     * Finds the <?= $modelClass ?> model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return <?=                   $modelClass ?> the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(<?= $actionParams ?>)
    {
        if ($model = <?= $modelClass ?>::findOne(<?= $condition ?>)) {
            return $model;
        }

        throw new NotFoundHttpException(<?= $generator->generateString('The requested page does not exist.') ?>);
    }
}

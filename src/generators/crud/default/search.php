<?php
/**
 * This is the template for generating CRUD search class of the specified model.
 */

use yii\helpers\StringHelper;

/** @var yii\web\View $this */
/** @var vasadibt\materialdashboard\generators\crud\Generator $generator */

$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);

$labels = $generator->generateSearchLabels();
$searchAttributes = $generator->getSearchAttributes();
$searchConditions = $generator->generateSearchConditions();

echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->searchModelClass, '\\')) ?>;

use <?= ltrim($generator->modelClass, '\\') ?>;
use <?= ltrim($generator->searchModelInterface, '\\') ?>;
use <?= ltrim($generator->searchModelTrait, '\\') ?>;
use yii\db\QueryInterface;

/**
 * <?= $searchModelClass ?> represents the model behind the search form of `<?= $generator->modelClass ?>`.
 */
class <?= $searchModelClass ?> extends <?= $modelClass ?> implements <?= StringHelper::basename($generator->searchModelInterface) . "\n" ?>
{
    use <?= StringHelper::basename($generator->searchModelTrait) ?>;

    /**
     * {@inheritDoc}
     */
    public function rules()
    {
        return [
<?php foreach ($generator->generateSearchRules() as $rule): ?>
            <?= $rule ?>,
<?php endforeach ?>
        ];
    }

    /**
     * @param QueryInterface $query
     * @return <?= StringHelper::basename($generator->searchModelInterface) . "\n" ?>
     */
    public function filterQuery(QueryInterface $query): <?= StringHelper::basename($generator->searchModelInterface) . "\n" ?>
    {
        $query->andFilterWhere(['AND',
<?php foreach($generator->getSearchConditions() as $column => $type): ?>
<?php if ($type == $generator::SIMPLE): ?>
            ['=', '<?= $generator->getTableSchema()->name ?>.<?= $column ?>', $this-><?= $column ?>],
<?php else: ?>
            ['<?= $type ?>', '<?= $generator->getTableSchema()->name ?>.<?= $column ?>', $this-><?= $column ?>],
<?php endif; ?>
<?php endforeach ?>
        ]);
        return $this;
    }
}
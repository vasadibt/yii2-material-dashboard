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
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\data\Pagination;
use yii\data\Sort;
use yii\db\ActiveQueryInterface;
use yii\web\Request;

/**
 * <?= $searchModelClass ?> represents the model behind the search form of `<?= $generator->modelClass ?>`.
 */
class <?= $searchModelClass ?> extends <?= $modelClass ?> implements <?= StringHelper::basename($generator->searchModelInterface) . "\n" ?>
{
    /**
     * @var Pagination|array|false
     */
    public $pagination;
    /**
     * @var Sort|array|false
     */
    public $sort;
    /**
     * @var DataProviderInterface
     */
    protected $dataProvider;

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
     * {@inheritDoc}
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * {@inheritDoc}
     */
    public function attributeLabels()
    {
        return [
<?php foreach ($generator->generateSearchLabels() as $attribute => $label): ?>
            '<?= $attribute ?>' => '<?= $label ?>',
<?php endforeach ?>
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param Request $request
     * @return <?= StringHelper::basename($generator->searchModelInterface) . "\n" ?>
     */
    public function search(Request $request): <?= StringHelper::basename($generator->searchModelInterface) . "\n" ?>
    {
        $query = <?= $modelClass ?>::find();

        $this->dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $this->pagination ?? ($request->get('per-page') == '-' ? false : []),
            'sort' => $this->sort ?? [],
        ]);

        $this->load($request->getQueryParams());

        if (!$this->validate()) {
            return $this;
        }

        return $this->filterQuery($query);
    }

    /**
     * @param ActiveQueryInterface $query
     * @return <?= StringHelper::basename($generator->searchModelInterface) . "\n" ?>
     */
    public function filterQuery($query): <?= StringHelper::basename($generator->searchModelInterface) . "\n" ?>
    {
        $query->andFilterWhere(['AND',
<?php foreach($generator->getSearchConditions() as $column => $type): ?>
<?php if ($type == $generator::SIMPLE): ?>
            ['<?= $generator->getTableSchema()->name ?>.<?= $column ?>' => $this-><?= $column ?>],
<?php else: ?>
            ['<?= $type ?>', '<?= $generator->getTableSchema()->name ?>.<?= $column ?>', $this-><?= $column ?>],
<?php endif; ?>
<?php endforeach ?>
        ]);

        return $this;
    }

    /**
     * Get Search model built DataProvider object
     *
     * @return DataProviderInterface
     */
    public function getDataProvider(): DataProviderInterface
    {
        return $this->dataProvider;
    }

    /**
     * Set Search model built DataProvider object
     *
     * @param DataProviderInterface $dataProvider
     */
    public function setDataProvider(DataProviderInterface $dataProvider)
    {
        $this->dataProvider = $dataProvider;
    }
}
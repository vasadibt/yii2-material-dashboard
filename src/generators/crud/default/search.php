<?php
/**
 * This is the template for generating CRUD search class of the specified model.
 */

use yii\helpers\StringHelper;


/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);

$rules = $generator->generateSearchRules();
$labels = $generator->generateSearchLabels();
$searchAttributes = $generator->getSearchAttributes();
$searchConditions = $generator->generateSearchConditions();

echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->searchModelClass, '\\')) ?>;

use <?= ltrim($generator->modelClass, '\\') ?>;
use vasadibt\materialdashboard\interfaces\SearchModelInterface;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQueryInterface;
use yii\web\Request;

/**
 * <?= $searchModelClass ?> represents the model behind the search form of `<?= $generator->modelClass ?>`.
 */
class <?= $searchModelClass ?> extends <?= $modelClass ?> implements SearchModelInterface
{
    /**
     * @var DataProviderInterface
     */
    public $dataProvider;

    /**
     * {@inheritDoc}
     */
    public function rules()
    {
        return [
            <?= implode(",\n            ", $rules) ?>,
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
     * Creates data provider instance with search query applied
     *
     * @param Request $request
     * @return $this
     */
    public function search(Request $request): self
    {
        $query = <?= $modelClass ?>::find();

        // add conditions that should always apply here

        $this->dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $request->get('per-page') == '-' ? false : [],
        ]);

        $this->load($request->getQueryParams());

        if (!$this->validate()) {
            return $this;
        }

        return $this->filterQuery($query);
    }

    /**
     * @param ActiveQueryInterface $query
     * @return $this
     */
    public function filterQuery($query): self
    {
        <?= implode("\n        ", $searchConditions) ?>

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
}
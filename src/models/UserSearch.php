<?php

namespace vasadibt\materialdashboard\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use common\models\User;
use yii\db\ActiveQueryInterface;
use yii\db\ActiveRecord;
use yii\web\Request;

/**
 * UserSearch represents the model behind the search form of `common\models\User`.
 *
 * @property string $username
 * @property string $email
 * @property integer $status
 */
class UserSearch extends ActiveRecord implements SearchModelInterface
{
    /**
     * @var DataProviderInterface
     */
    public DataProviderInterface $dataProvider;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @return array
     */
    public static function statusLabels()
    {
        return [
            9 => Yii::t('materialdashboard', 'Inactive'),
            10 => Yii::t('materialdashboard', 'Active'),
            0 => Yii::t('materialdashboard', 'Deleted'),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['username', 'email'], 'safe'],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param Request $request
     * @return $this
     */
    public function search(Request $request): self
    {
        $query = User::find();

        // add conditions that should always apply here
        $this->dataProvider = new ActiveDataProvider([
            'query' => $query,
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
        $query
            ->andFilterWhere(['=', 'status', $this->status])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email]);

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

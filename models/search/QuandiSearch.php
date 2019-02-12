<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\httpclient\Client;

/**
 * Class QuandiSearch
 *
 * @package app\models\search
 */
class QuandiSearch extends Model
{
    const REQUEST_URL = 'https://www.quandl.com/api/v3/datasets/WIKI/{company_symbol}.json?api_key={api_key}&order=asc&start_date={start_date}&end_date={end_date}';
    const PARAMS_URL = ['{api_key}', '{company_symbol}', '{start_date}', '{end_date}'];

    const OPEN_FIELD = 'Open';
    const CLOSE_FIELD = 'Close';
    const DATE_FIELD = 'Date';
    const HIGH_FIELD = 'High';
    const LOW_FIELD = 'Low';
    const VOLUME_FIELD = 'Volume';

    const ALLOW_FIELDS = [
        self::DATE_FIELD,
        self::OPEN_FIELD,
        self::HIGH_FIELD,
        self::LOW_FIELD,
        self::CLOSE_FIELD,
        self::VOLUME_FIELD
    ];

    /** @var string */
    public $companySymbol;
    /** @var string */
    public $email;
    /** @var string */
    public $startAt;
    /** @var string */
    public $endAt;

    /** @var array */
    private $fields = [];
    /** @var array */
    private $columns = [];

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['companySymbol'], 'required'],
            [['companySymbol'], 'string'],
            [['email'], 'email'],
            [['companySymbol', 'email'], 'trim'],
            [['startAt', 'endAt'], 'default', 'value' => null],
            [['startAt', 'endAt'], 'date', 'format' => 'php:Y-m-d'],
            [['startAt', 'endAt'], 'dateRangeValidate'],
        ];
    }

    /**
     * @param array $params
     * @return ArrayDataProvider
     */
    public function search($params = [])
    {
        $dataProvider = $this->dataProvider();

        if (!$this->load($params) || !$this->validate()) {
            return $dataProvider;
        }

        $response = $this->sendRequest();

        if (!$response) {
            return $dataProvider;
        }

        $this->fields = ArrayHelper::getValue($response, 'dataset.column_names');
        $data = ArrayHelper::getValue($response, 'dataset.data', []);

        if (empty($this->fields)) {
            $error = ArrayHelper::getValue($response, 'quandl_error.message');

            Yii::$app->session->setFlash('error', $error);
        }

        return $this->dataProvider($data);
    }

    /**
     * Custom date range validator
     */
    public function dateRangeValidate()
    {
        $isFilledRange = !empty($this->startAt) && !empty($this->endAt);
        $isInvalidValue = $this->startAt > $this->endAt;

        if ($isFilledRange && $isInvalidValue) {
            $this->addError('startAt', 'startAt cannot be greater than endAt');
            $this->addError('endAt', 'endAt cannot be less than startAt');
        }
    }

    /**
     * @return array
     */
    public function getColumns()
    {
        if (!empty($this->columns)) {
            return $this->columns;
        }

        if (empty($this->fields) || !is_array($this->fields)) {
            return $this->columns;
        }

        foreach ($this->fields as $attribute => $label) {
            if (!in_array($label, self::ALLOW_FIELDS)) {
                continue;
            }

            $this->columns[] = [
                'attribute' => $attribute,
                'label' => $label,
            ];
        }

        return $this->columns;
    }

    /**
     * @param string $label
     * @return null|int
     */
    public function getAttributeByLabel(string $label)
    {
        $columnAttribute = null;
        $columns = $this->getColumns();

        if (empty($columns)) {
            return $columnAttribute;
        }

        foreach ($columns as $column) {
            if ($column['label'] == $label) {
                $columnAttribute = $column['attribute'];

                break;
            }
        }

        return $columnAttribute;
    }

    /**
     * @param array $data
     * @return ArrayDataProvider
     */
    private function dataProvider($data = [])
    {
        return new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
    }

    /**
     * @return array|bool|mixed
     */
    private function sendRequest()
    {
        try {
            $client = new Client(['transport' => 'yii\httpclient\CurlTransport']);
            $request = $client->createRequest()
                ->setMethod('get')
                ->setUrl($this->getPreparedUrl())
                ->send();
        } catch (\yii\httpclient\Exception $e) {
            $errorMessage = $e->getMessage();
            Yii::error($errorMessage);

            Yii::$app->session->setFlash('error', $errorMessage);

            return false;
        }

        return $request->getData();
    }

    /**
     * @return mixed
     */
    private function getPreparedUrl()
    {
        return str_replace(self::PARAMS_URL, [
            Yii::$app->params['quandiApiKey'],
            $this->companySymbol,
            $this->startAt,
            $this->endAt
        ], self::REQUEST_URL);
    }
}
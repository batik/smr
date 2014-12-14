<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\AttributeValue;
use app\models\Product;
use app\models\Attribute;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AttributevalueController implements the CRUD actions for AttributeValue model.
 */
class AttributevalueController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Creates a new AttributeValue model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($productId)
    {
        $model = new AttributeValue();
        $model->productId = $productId;

        $product = Product::find()->where(['id' => $productId])->one();
        $existValues = $product->getAttributevalues()->select(['attributeId as id'])->asArray()->all();

        $category = $product->getCategory()->one();
        
        $attributes = Attribute::find()->where(['categoryId' => [$category->id, $category->getParent()->one()->id]])
            ->andWhere(['not in', 'id', $existValues])->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['product/view', 'id' => $model->productId]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'attributes' => $attributes,
            ]);
        }
    }

    /**
     * Updates an existing AttributeValue model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $productId
     * @param integer $attributeId
     * @return mixed
     */
    public function actionUpdate($productId, $attributeId)
    {
        $model = $this->findModel($productId, $attributeId);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['product/view', 'id' => $model->productId]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing AttributeValue model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $productId
     * @param integer $attributeId
     * @return mixed
     */
    public function actionDelete($productId, $attributeId)
    {
        $this->findModel($productId, $attributeId)->delete();

        return $this->redirect(['product/view', 'id' => $productId]);
    }

    /**
     * Finds the AttributeValue model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $productId
     * @param integer $attributeId
     * @return AttributeValue the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($productId, $attributeId)
    {
        if (($model = AttributeValue::findOne(['productId' => $productId, 'attributeId' => $attributeId])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

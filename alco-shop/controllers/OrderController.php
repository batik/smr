<?php

namespace app\controllers;

use Yii;
use app\models\Order;
use app\models\Product;
use app\models\ProductList;
use app\models\OrderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;

/**
 * OrderController implements the CRUD actions for order model.
 */
class OrderController extends Controller
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
     * Displays a single order model.
     * @param integer $id
     * @return mixed
     */
    public function actionView()
    {
        $productLists = [];
        $total = 0;
        if($_COOKIE['cart'] != '')
        {
            $productLists = json_decode($_COOKIE['cart']);
        }
        foreach($productLists as $productList) {
            $productList->name = Product::find()->where(['id' => $productList->productId])->one()->name;
            $total += $productList->price * $productList->quantity;
        }

        $provider = new ArrayDataProvider(
            [
                'allModels' => $productLists,
            ]);
        return $this->render('view', [
            'provider' => $provider,
            'total' => $total,
        ]);
    }

    /**
     * Creates a new order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $productLists = [];
        if(isset($_COOKIE['cart'])) 
        {
            $productLists = json_decode($_COOKIE['cart']);
        }

        $orderModel = new Order();        

        if ($orderModel->load(Yii::$app->request->post()) && $orderModel->save()) {
            foreach($productLists as $productList) {
                $prodModel = new ProductList();
                $data = [];
                $productList->orderId = $orderModel->id;
                $data['ProductList'] = (array)$productList;
                $prodModel->load($data);
                $prodModel->save();
            }
            setcookie('cart', '[]', time() + 3600*24, '/');
            setcookie('count', '0', time() + 3600*24, '/');
            return $this->redirect(['product/all']);
        } else {
            return $this->redirect('view');
        }
    }

   /**
     * Finds the order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

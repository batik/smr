<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Product;
use app\models\PriceSnapshot;
use app\models\AttributeValue;
use app\models\ProductSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
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
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->redirect(['all']);
    }

    public function actionAll()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $modelAttributes = new ActiveDataProvider([
            'query' => $model->getAttributevalues(),
            'sort' => false,
        ]);

        return $this->render('view', [
            'model' => $model,
            'modelAttributes' => $modelAttributes,
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();

        if (isset($_FILES['Product']) 
            && ($_FILES['Product']['name']['photo'] != '')) 
        {
            $rnd = rand(0,9999);
            $uploadedFile = UploadedFile::getInstance($model,'photo');
            $fileName = 'files/'.$rnd.'_'.$uploadedFile->name;
            Yii::info($fileName);
            $_POST['Product']['photo'] = $fileName;
            $uploadedFile->saveAs($fileName);
        }

        if ($model->load($_POST) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldPrice = $model->price;

        $fileName = $model->photo;
        if (isset($_FILES['Product'])) 
        {
            if($_FILES['Product']['name']['photo'] != '')
            {
                $rnd = rand(0,9999);
                $uploadedFile = UploadedFile::getInstance($model,'photo');
                if($fileName != "")
                {
                   unlink($fileName);
                }
                $fileName = 'files/'.$rnd.'_'.$uploadedFile->name;
                $uploadedFile->saveAs($fileName);
            }
            $_POST['Product']['photo'] = $fileName;
        }

        if ($model->load($_POST) && $model->save()) {
            if($model->price != $oldPrice)
            {
                $ps = new PriceSnapshot();
                $ps->productId = $model->id;
                $ps->price = $oldPrice;
                $ps->save();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

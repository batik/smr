<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Category;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
{

    private $image_array = ['image/gif, image/jpeg, image/png'];


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
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->redirect(['all']);
    }

    public function actionAll()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Category::find(),
            'sort' => 
            [
                'attributes' => 
                [
                    'name',
                    'Parent category' => 
                    [
                        'asc' => ['parentId' => SORT_ASC],
                        'desc' => ['parentId' => SORT_DESC],
                    ],
                ]
            ]
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Category model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Category();

        if (isset($_FILES['Category']) 
            && ($_FILES['Category']['name']['photo'] != '')) 
        {
            $rnd = rand(0,9999);
            $uploadedFile = UploadedFile::getInstance($model,'photo');
            $fileName = 'files/'.$rnd.'_'.$uploadedFile->name;
            $_POST['Category']['photo'] = $fileName;
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
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $fileName = $model->photo;
        if (isset($_FILES['Category'])) 
        {
            if($_FILES['Category']['name']['photo'] != '')
            {
                $rnd = rand(0,9999);
                $uploadedFile = UploadedFile::getInstance($model,'photo');
                unlink($fileName);
                $fileName = 'files/'.$rnd.'_'.$uploadedFile->name;
                $uploadedFile->saveAs($fileName);
            }
            $_POST['Category']['photo'] = $fileName;
        }

        if ($model->load($_POST) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Category model.
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
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

<?php

namespace backend\modules\main\controllers;

use common\models\project\UploadForm;
use yii\web\UploadedFile;
use backend\assets_b\Project;
use Yii;
use common\models\project\Seller;
use common\models\project\City;
use common\models\project\ProductCategory;
use common\models\project\ModelProject;
use common\models\project\County;
use common\models\project\ProductSaleSub;
use common\models\project\ProductSaleSubSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\response;
use yii\helpers\Json;
use common\models\project\Product;


/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductSaleSubController extends Controller
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
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSaleSubSearch();
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
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $modelImage = new UploadForm();
        $model = new ProductSale();
        $maxId = ProductSale::find()->orderBy('id DESC')->one();
        $nextID = isset($maxId) ? $maxId->id : 0;
        $model->code = 'SP00' . ($nextID + 1);
        $model->type = 1;
        $modelProductCategory = ProductCategory::find()->all();
        $modelProject = ModelProject::find()->all();
        $modelCounty = County::find()->all();
        $modelCity = City::find()->all();
        if ($model->load(Yii::$app->request->post())) {


            //Upload image
            $modelImage->imageFiles = UploadedFile::getInstances($modelImage, 'imageFiles');
            if ($modelImage->validate()&&$model->validate()) {
                $model->total_price = $model->price * $model->acreage;
                $imageName = $model->code;
                foreach ($modelImage->imageFiles as $key => $file) {
                    $key++;
                    $file->saveAs('C:\xampp\htdocs\project\backend\uploads/' . $imageName . '_' . $key . '.' . $file->extension);
                    $value = 'C:\xampp\htdocs\project\backend\uploads/' . $imageName . '_' . $key . '.' . $file->extension;
                    //save to db
                    $sql = (new \yii\db\Query())->createCommand()->insert('m_image', ['product_id' => ($nextID + 1), 'logo' => $value])->execute();
                }
            }
            if ($model->save()) {
                Yii::$app->getSession()->setFlash('alert', [
                    'body' => 'Thêm mới thành công.',
                    'options' => ['class' => 'ialert alert-success']
                ]);
                return $this->redirect(['index']);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'modelCity' => ArrayHelper::map($modelCity, 'id', 'name'),
            'modelCounty' => ArrayHelper::map($modelCounty, 'id', 'name'),
            'modelProject' => ArrayHelper::map($modelProject, 'id', 'name'),
            'modelProductCategory' => ArrayHelper::map($modelProductCategory, 'id', 'name'),
            'modelImage' => $modelImage,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $modelImage = new UploadForm();
        $model = $this->findModel($id);

        $modelProductCategory = ProductCategory::find()->all();
        $modelProject = ModelProject::find()->all();
        $modelCounty = County::find()->all();
        $modelCity = City::find()->all();

        if ($model->load(Yii::$app->request->post())) {
            $model->total_price = $model->price * $model->acreage;
            if ($model->save()) {
                Yii::$app->getSession()->setFlash('alert', [
                    'body' => 'Cập nhật thành công.',
                    'options' => ['class' => 'ialert alert-success']
                ]);
                return $this->redirect(['index']);
            }
        }
        return $this->render('update', [
            'model' => $model,
            'modelCity' => ArrayHelper::map($modelCity, 'id', 'name'),
            'modelCounty' => ArrayHelper::map($modelCounty, 'id', 'name'),
            'modelProject' => ArrayHelper::map($modelProject, 'id', 'name'),
            'modelProductCategory' => ArrayHelper::map($modelProductCategory, 'id', 'name'),
            'modelImage' => $modelImage,
        ]);
    }

    public function actionAjaxDelete()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (isAjax()) {
            $dataPost = $_POST;
            $dataId = isset($dataPost['ids']) ? $dataPost['ids'] : [];
            foreach ($dataId as $item) {
                /** @var ProductSale $mode */
                $mode = ProductSale::find()->where(['id' => $item])->one();
                if ($mode) {
                    $mode->deleted = 0;
                    $mode->save();
                }
            }
            $res = [
                'body' => 'Sucess',
                'success' => true,
            ];
            return $res;
        }
        $res = [
            'body' => 'Not allow',
            'success' => false,
        ];
        return $res;
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->deleted = 0;
        $model->save();
        Yii::$app->getSession()->setFlash('alert', [
            'body' => 'Xóa dữ liệu thành công.',
            'options' => ['class' => 'ialert alert-success']
        ]);
        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductSale the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductSale::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The Product item does not exist.');
        }
    }

    public function actionAjaxInfo()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $dataGet = $_GET;
        $dataId = isset($dataGet['id']) ? $dataGet['id'] : [];
        if (isset($dataId)){
            $product = [];
            $dataCarOwner = [];
            if ($dataId && is_numeric($dataId)) {
                $product = ProductSale::find()->where(['id' => $dataId])->one();
                $product_category_id = $product->product_category_id;
                $product_category = ProductCategory::find()->where(['id' => $product_category_id])->one()->name;
                $county_id = $product->county_id;
                $county = County::find()->where(['id' => $county_id])->one()->name;
                $city_id = $product->city_id;
                $city = City::find()->where(['id' => $city_id])->one()->name;
                $images = UploadForm::find()->where(['product_id' => $product->id])->all();
                $name_seller = isset($product->name_seller) ? Seller::findOne($product->name_seller)->name : 'Công ty BDS';
                $code_seller = isset($product->name_seller) ? Seller::findOne($product->name_seller)->code : 'CT';
                $address_seller = isset($product->name_seller) ? $product->address_seller : '64-Giáp Nhị-Hoàng Mai-Hà Nội';
                $mobile_seller = isset($product->name_seller) ? $product->mobile_seller : '043654597';
                $res = [
                    'name' => $product->name,
                    'code' => $product->code,
                    'product_category' => $product_category,
                    'county' => $county,
                    'city' => $city,
                    'address' => $product->address,
                    'price' => $product->price,
                    'acreage' => $product->acreage,
                    'total_price' => $product->total_price,
                    'floors' => $product->floors,
                    'rooms' => $product->rooms,
                    'bedrooms' => $product->bedrooms,
                    'bathrooms' => $product->bathrooms,
                    'description' => $product->description,
                    'images' => $images,
                    'name_seller' => $name_seller,
                    'code_seller' => $code_seller,
                    'address_seller' => $address_seller,
                    'mobile_seller' => $mobile_seller
                ];
                return $res;
        } else {
                $listProduct = ProductSale::find()->all();
                return $listProduct;
            }
        }
    }

    public function actionList()
    {
        if (isset($_POST['depdrop_parents'])) {
            $out = [];
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $type = $parents[0];
                $out = Product::find()
                    ->where(['type' => $type,'deleted'=>1])
                    ->orderBy('id desc')
                    ->asArray()->all();
                $data = [];
                foreach ($out as $item) {
                    $data_model = [];
                    $data_model['id'] = intval($item['id']);
                    $data_model['name'] = $item['name'];
                    $data[] = $data_model;
                }
                echo Json::encode(['output' => $data, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }
}

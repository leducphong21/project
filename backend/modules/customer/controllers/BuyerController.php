<?php

namespace backend\modules\customer\controllers;

use yii\db\Query;
use Yii;
use common\models\project\Buyer;
use common\models\project\BuyerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\response;

/**
 * BuyerController implements the CRUD actions for Customer model.
 */
class BuyerController extends Controller
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
     * Lists all Customer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BuyerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Customer model.
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
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Buyer();

        //code
        $maxId = Buyer::find()->orderBy('id DESC')->one();
        $nextID = isset($maxId) ? $maxId->id : 0;
        $model->code = 'NM00' .($nextID + 1);
        //Buyer
        $model->type=1;

        //format date
        if ($model->load(Yii::$app->request->post())) {
            if ($model->birth_day) {
                $model->birth_day = date('Y-m-d', strtotime(str_replace('/', '-', $model->birth_day)));
            }
            if($model->save()){
            Yii::$app->getSession()->setFlash('alert', [
                'body'=>'Thêm mới thành công.',
                'options'=>['class'=>'ialert alert-success']
            ]);
            return $this->redirect(['index']);
           }
        }
        return $this->render('create', [
        'model' => $model,
        ]);
    }

    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->birth_day) {
                $model->birth_day = date('Y-m-d', strtotime(str_replace('/', '-', $model->birth_day)));
            }
            if($model->save()){
            Yii::$app->getSession()->setFlash('alert', [
                'body'=>'Cập nhật thành công.',
                'options'=>['class'=>'ialert alert-success']
            ]);
            return $this->redirect(['index']);
            }
        }
        return $this->render('update', [
        'model' => $model,
        ]);
    }

    public function actionAjaxDelete()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (isAjax()) {
            $dataPost = $_POST;
            $dataId = isset($dataPost['ids']) ? $dataPost['ids'] : [];
            foreach ($dataId as $item) {
                /** @var Buyer $mode */
                $mode = Buyer::find()->where(['id' => $item])->one();
                if ($mode) {
                    $mode->deleted=0;
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
     * Deletes an existing Customer model.
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
     * Finds the Customer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Buyer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Buyer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The Customer item does not exist.');
        }
    }

    public function actionJsonList($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select('id, name AS text')
                ->from('m_customer')
                ->andWhere(['like', 'name', $q])
                ->andWhere(['m_customer.deleted' => 1])
                ->andWhere(['m_customer.type' => 1])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => Buyer::find($id)->name];
        }
        return $out;
    }

    public function actionAjaxSave()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new Buyer();

        $model->name = isset($_POST["name"]) ? $_POST['name'] : "";
        $model->gender = isset($_POST["gender"]) ? $_POST['gender'] : "";
        $date = isset($_POST["birthday"]) ? $_POST['birthday'] : "";
        $date = date('Y-m-d', strtotime(str_replace('/', '-', $date)));
        $model->birth_day=$date;
        $model->address = isset($_POST["address"]) ? $_POST['address'] : "";
        $model->phone_number = isset($_POST["mobile"]) ? $_POST['mobile'] : "";
        $model->email = isset($_POST["email"]) ? $_POST['email'] : "";
        $model->job = isset($_POST["job"]) ? $_POST['job'] : "";
        $model->tax_code = isset($_POST["tex_code"]) ? $_POST['tax_code'] : "";

        $maxId = Buyer::find()->orderBy('id DESC')->one();
        $nextID = isset($maxId) ? $maxId->id : 0;
        $model->code = 'NM00' .($nextID + 1);
        //Buyer
        $model->type=1;
        $model->save();

        return "aaaa";
    }
}

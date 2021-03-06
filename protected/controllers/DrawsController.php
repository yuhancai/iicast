<?php

class DrawsController extends Controller
{

    /**
     *
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     *      using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     *
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete'
        ); // we only allow deletion via POST request
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     *
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array(
                'allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array(
                    'index',
                    'view'
                ),
                'users' => array(
                    '*'
                )
            ),
            array(
                'allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array(
                    'create',
                    'update'
                ),
                'users' => array(
                    '@'
                )
            ),
            array(
                'allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array(
                    'admin',
                    'typical',
                    'delete'
                ),
                'users' => array(
                    'admin'
                )
            ),
            array(
                'deny', // deny all users
                'users' => array(
                    '*'
                )
            )
        );
    }

    /**
     * Displays a particular model.
     *
     * @param integer $id
     *            the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id)
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Draws();
        
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        
        if (isset($_POST['Draws'])) {
            $model->attributes = $_POST['Draws'];
            if ($model->save())
                $this->redirect(array(
                    'view',
                    'id' => $model->id
                ));
        }
        
        $this->render('create', array(
            'model' => $model
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *            the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        
        if (isset($_POST['Draws'])) {
            $model->attributes = $_POST['Draws'];
            if ($model->save())
                $this->redirect(array(
                    'view',
                    'id' => $model->id
                ));
        }
        
        $this->render('update', array(
            'model' => $model
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     *
     * @param integer $id
     *            the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();
        
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (! isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array(
                'admin'
            ));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        
        // print_r($this->cweight(1));
        $dataProvider = new CActiveDataProvider('Draws');
        $this->render('index', array(
            'dataProvider' => $dataProvider
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Draws('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Draws']))
            $model->attributes = $_GET['Draws'];
        
        $this->render('admin', array(
            'model' => $model
        ));
    }
    /**
     * Manages all models.
     */
    public function actionTypical()
    {
        // Create filter model and set properties
        $filtersForm=new FiltersForm;
        if (isset($_GET['FiltersForm']))
        $filtersForm->filters=$_GET['FiltersForm']; 
        $criteria = new CDbCriteria;
        $criteria->select = array('*');
        $criteria->condition = 'abs(strftime(\'%H\',open_at)) >'.date("H").' and abs(strftime(\'%H\',begin_at))=8';
        $result=Draws::model()->with('item')->findAll($criteria);     
        $count=Draws::model()->count($criteria);
        $pages=new CPagination($count);
        $pages->setPageSize(20);
        //Draws::model()->setAttrubites("bymins");      
  
        $sort = new CSort();
        $sort->attributes = array(
            'luckynum', 'begin_at', 'lucky_at', 'open_at','itemname','Bymins',
            'qishu'=>array(
                'asc'=>'qishu DESC',
                'desc'=>'qishu ASC',
            ),
        );
        $sort->route = 'draws/typical';
        $filteredData=$filtersForm->filter($result);
        $dataProvider=new CArrayDataProvider($filteredData,array(
            'sort'=>$sort,
            'pagination'=>$pages,
        )
        );
       // $dataProvider->sort = $sort;
        $dataProvider->sort->defaultOrder='qishu DESC';   
        
     
        
        
 
   /*      $item=Draws::model()->with('item')->findAll();
        $model = new Draws('searchCurrent');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Draws']))
            $model->attributes = $_GET['Draws'];   */
        
        $this->render('typical', array(
            'model' => $dataProvider,
            'filtersForm' => $filtersForm,
            //'item'=>$item,
        ));
    }
    
    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     *
     * @param integer $id
     *            the ID of the model to be loaded
     * @return Draws the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Draws::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function cweight($data, $row)
    {
        $sql = 'SELECT *from tbl_draws WHERE itemid = ' . $data->itemid;
        $sql .= ' and qishu>=';
        $sql .= $data->qishu;
        $sql .= ' limit 2';
        $rows = Yii::app()->db->createCommand($sql)->queryAll();
        $result = '';
        if (! empty($rows)&&count($rows)==2) {
            foreach ($rows as $row) {
                $d=Util::caculateDiffByMinutes($row['begin_at'], $row['lucky_at']);
                $result +=$d . '<br/>';
                $d_a[]=$d;
            }

                $result =round($result/2)."="."(".$d_a[0]."+".$d_a[1].")"."/2";
        }
        else $result=0;
        return $result;
    }
    protected function c3weight($data, $row)
    {
        $sql = 'SELECT *from tbl_draws WHERE itemid = ' . $data->itemid;
        $sql .= ' and qishu>=';
        $sql .= $data->qishu;
        $sql .= ' limit 3';
        $rows = Yii::app()->db->createCommand($sql)->queryAll();
        $result = '';
        if (! empty($rows)&&count($rows)==3) {
            foreach ($rows as $row) {
                $d=Util::caculateDiffByMinutes($row['begin_at'], $row['lucky_at']);
                $result +=$d . '<br/>';
                $d_a[]=$d;
            }
    
            $result =round($result/3)."="."(".$d_a[0]."+".$d_a[1]."+".$d_a[2].")"."/3 ";
        }
        else $result=0;
        return $result;
    }
    /**
     * Performs the AJAX validation.
     *
     * @param Draws $model
     *            the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'draws-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}

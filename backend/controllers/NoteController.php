<?php

namespace backend\controllers;

use common\models\Note;
use common\models\search\NoteSearch;
use common\components\Settings;
use Yii;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * NoteController implements the CRUD actions for Note model.
 */
class NoteController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'only' => ['index', 'view', 'create', 'update', 'delete', 'toggle-pin'],
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Note models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new NoteSearch();
        $searchModel->user_id = Yii::$app->user->id;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return string|Response
     */
    public function actionCreate(): Response|string
    {
        $model = new Note();

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionStore(): Response
    {
        $model = new Note();

        if ($this->request->isPost) {
            $model->user_id = Yii::$app->user->id;
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Заметка успешно создана!');
            } else {
                Yii::$app->session->setFlash('error', Settings::errorText($model->errors));
            }
        }

        return $this->redirect(['index']);
    }

    public function actionEdit($id): Response|string
    {
        $model = Note::findOne($id);

        if ($model->user_id != Yii::$app->user->id) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Note model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|Response
     * @throws NotFoundHttpException if the model cannot be found
     * @throws Exception
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (
            ($model->user_id == Yii::$app->user->id)
            && $this->request->isPost
            && $model->load($this->request->post())
            && $model->save()
        ) {
            Yii::$app->session->setFlash('success', 'Заметка успешно создана!');
        } else {
            Yii::$app->session->setFlash('error', Settings::errorText($model->errors));
        }


        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Note model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDestroy(int $id)
    {
        $model = $this->findModel($id);
        if ($model->user_id == Yii::$app->user->id) {
            try {
                $model->delete();
            } catch (\Throwable $e) {
                Yii::$app->errorHandler->logException($e);
            }
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Note model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Note the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Note::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionTogglePin($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = Note::find()
            ->where([
                'id' => $id,
                'user_id' => Yii::$app->user->id
            ])
            ->one();

        if (!$model) {
            return ['success' => false];
        }

        $model->is_pinned = !$model->is_pinned;
        $model->save(false);

        return [
            'success' => true,
            'pinned' => $model->is_pinned
        ];
    }
}

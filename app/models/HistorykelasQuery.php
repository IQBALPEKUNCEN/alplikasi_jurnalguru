<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Historykelas]].
 *
 * @see Historykelas
 */
class HistorykelasQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Historykelas[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Historykelas|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

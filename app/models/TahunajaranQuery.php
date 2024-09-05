<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Tahunajaran]].
 *
 * @see Tahunajaran
 */
class TahunajaranQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Tahunajaran[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Tahunajaran|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

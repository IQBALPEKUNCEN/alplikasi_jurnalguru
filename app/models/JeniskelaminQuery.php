<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Jeniskelamin]].
 *
 * @see Jeniskelamin
 */
class JeniskelaminQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Jeniskelamin[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Jeniskelamin|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Jurusan]].
 *
 * @see Jurusan
 */
class JurusanQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Jurusan[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Jurusan|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

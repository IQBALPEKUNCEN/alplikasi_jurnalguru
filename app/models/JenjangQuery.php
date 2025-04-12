<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Jenjang]].
 *
 * @see Jenjang
 */
class JenjangQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Jenjang[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Jenjang|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

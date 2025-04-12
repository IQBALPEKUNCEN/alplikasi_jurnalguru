<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[JurnalDetil]].
 *
 * @see JurnalDetil
 */
class JurnalDetilQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return JurnalDetil[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return JurnalDetil|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

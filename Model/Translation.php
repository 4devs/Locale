<?php

namespace FDevs\Locale\Model;

use Doctrine\Common\Collections\Collection;

class Translation
{
    /** @var string */
    protected $id;

    /** @var array|Collection|LocaleText[] */
    protected $trans;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return array|Collection|LocaleText[]
     */
    public function getTrans()
    {
        return $this->trans;
    }

    /**
     * @param array|Collection|LocaleText[] $trans
     *
     * @return self
     */
    public function setTrans($trans)
    {
        $this->trans = $trans;

        return $this;
    }
}

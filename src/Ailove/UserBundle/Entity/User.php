<?php
namespace Ailove\UserBundle\Entity;

use Sonata\UserBundle\Entity\BaseUser as BaseUser;

class User extends BaseUser
{

    /**
     * @var integer $id
     */
    protected $id;
 
    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    protected $vkontakteUid;

    /**
     * Set vkontakteUid
     *
     * @param string $vkontakteUid
     *
     * @return User
     */
    public function setVkontakteUid($vkontakteUid)
    {
        $this->vkontakteUid = $vkontakteUid;

        return $this;
    }

    /**
     * Get vkontakteUid
     *
     * @return string
     */
    public function getVkontakteUid()
    {
        return $this->vkontakteUid;
    }
}

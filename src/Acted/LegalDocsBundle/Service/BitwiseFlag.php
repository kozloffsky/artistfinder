<?php

namespace Acted\LegalDocsBundle\Service;

use Doctrine\ORM\EntityManager;

class BitwiseFlag
{
    public $flags;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function isFlagSet($flag)
    {
        return (($this->flags & $flag) == $flag);
    }

    public function setFlag($flag, $value)
    {
        if($value) {
            $this->flags |= $flag;
        } else {
            $this->flags &= ~$flag;
        }
    }
}

/*class TestBitwise extends BitwiseFlag
{
    const FLAG_REGISTERED = 1; // BIT #1 of $flags has the value 1
    const FLAG_ACTIVE = 2;// BIT #2 of $flags has the value 2
    public $bitwiseFlag;

    public function __construct()
    {
        this->bitwiseFlag = new BitwiseFlag();
    }

    public function isRegistered(){
        return $this->bitwiseFlag->isFlagSet(self::FLAG_REGISTERED);
    }

    public function isActive(){
        return $this->bitwiseFlag->isFlagSet(self::FLAG_ACTIVE);
    }

    public function setRegistered($value){
        $this->bitwiseFlag->setFlag(self::FLAG_REGISTERED, $value);
    }

    public function setActive($value){
        $this->bitwiseFlag->setFlag(self::FLAG_ACTIVE, $value);
    }

    public function getFlags() {
        return $this->bitwiseFlag->flags;
    }
}*/
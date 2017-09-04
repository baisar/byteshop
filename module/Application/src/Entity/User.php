<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
 */
class User
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nick", type="string", length=100, precision=0, scale=0, nullable=false, unique=false)
     */
    private $nick;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100, precision=0, scale=0, nullable=false, unique=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="pass", type="string", length=400, precision=0, scale=0, nullable=false, unique=false)
     */
    private $pass;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=200, precision=0, scale=0, nullable=true, unique=false)
     */
    private $token;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_visit", type="datetime", precision=0, scale=0, nullable=true, unique=false)
     */
    private $lastVisit;

    /**
     * @var string
     *
     * @ORM\Column(name="registered_from_ip", type="string", length=100, precision=0, scale=0, nullable=true, unique=false)
     */
    private $registeredFromIp;

    /**
     * @var string
     *
     * @ORM\Column(name="avatar", type="string", length=400, precision=0, scale=0, nullable=true, unique=false)
     */
    private $avatar;

    /**
     * @var string
     *
     * @ORM\Column(name="cell", type="integer", length=9, precision=0, scale=0, nullable=true, unique=false)
     */
    private $cell; 

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="reg_date", type="date", precision=0, scale=0, nullable=true, unique=false)
     */
    private $regDate;

    /**
     * @var string
     *
     * @ORM\Column(name="thumbnail", type="string", length=4000, precision=0, scale=0, nullable=true, unique=false)
     */
    private $thumbnail;

    /**
     * @var boolean
     *
     * @ORM\Column(name="email_confirmed", type="boolean", precision=0, scale=0, nullable=true, unique=false)
     */
    private $emailConfirmed;

    /**
     * @var integer
     *
     * @ORM\Column(name="role", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $role;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nick
     *
     * @param string $nick
     *
     * @return User
     */
    public function setNick($nick)
    {
        $this->nick = $nick;

        return $this;
    }

    /**
     * Get nick
     *
     * @return string
     */
    public function getNick()
    {
        return $this->nick;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set pass
     *
     * @param string $pass
     *
     * @return User
     */
    public function setPass($pass)
    {
        $this->pass = $pass;

        return $this;
    }

    /**
     * Get pass
     *
     * @return string
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * Set token
     *
     * @param string $token
     *
     * @return User
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set lastVisit
     *
     * @param \DateTime $lastVisit
     *
     * @return User
     */
    public function setLastVisit($lastVisit)
    {
        $this->lastVisit = $lastVisit;

        return $this;
    }

    /**
     * Get lastVisit
     *
     * @return \DateTime
     */
    public function getLastVisit()
    {
        return $this->lastVisit;
    }

    /**
     * Set registeredFromIp
     *
     * @param string $registeredFromIp
     *
     * @return User
     */
    public function setRegisteredFromIp($registeredFromIp)
    {
        $this->registeredFromIp = $registeredFromIp;

        return $this;
    }

    /**
     * Get registeredFromIp
     *
     * @return string
     */
    public function getRegisteredFromIp()
    {
        return $this->registeredFromIp;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     *
     * @return User
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set cell
     *
     * @param integer $cell
     *
     * @return User
     */
    public function setCell($cell)
    {
        $this->cell = $cell; 

        return $this;
    }

    /**
     * Get cell
     *
     * @return integer
     */
    public function getCell()
    {
        return $this->cell; 
    }

    /**
     * Set regDate
     *
     * @param \DateTime $regDate
     *
     * @return User
     */
    public function setRegDate($regDate)
    {
        $this->regDate = $regDate;

        return $this;
    }

    /**
     * Get regDate
     *
     * @return \DateTime
     */
    public function getRegDate()
    {
        return $this->regDate;
    }

    /**
     * Set thumbnail
     *
     * @param string $thumbnail
     *
     * @return User
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    /**
     * Get thumbnail
     *
     * @return string
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * Set emailConfirmed
     *
     * @param boolean $emailConfirmed
     *
     * @return User
     */
    public function setEmailConfirmed($emailConfirmed)
    {
        $this->emailConfirmed = $emailConfirmed;

        return $this;
    }

    /**
     * Get emailConfirmed
     *
     * @return boolean
     */
    public function getEmailConfirmed()
    {
        return $this->emailConfirmed;
    }

    /**
     * Set role
     *
     * @param integer $role
     *
     * @return User
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return integer
     */
    public function getRole()
    {
        return $this->role;
    }
}


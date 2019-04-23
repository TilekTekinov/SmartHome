<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sensors
 *
 * @ORM\Table(name="sensors")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SensorsRepository")
 */
class Sensors
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="temperature", type="integer", nullable=true)
     */
    private $temperature;

    /**
     * @var int
     *
     * @ORM\Column(name="humidity", type="integer", nullable=true)
     */
    private $humidity;

    /**
     * @var int
     *
     * @ORM\Column(name="photoresistor", type="integer", nullable=true)
     */
    private $photoresistor;

    /**
     * @var bool
     *
     * @ORM\Column(name="motion", type="boolean", nullable=true)
     */
    private $motion;

    /**
     * @var int
     *
     * @ORM\Column(name="gas", type="integer", nullable=true)
     */
    private $gas;

    /**
     * @var bool
     *
     * @ORM\Column(name="socket1", type="boolean", nullable=true)
     */
    private $socket1;

    /**
     * @var bool
     *
     * @ORM\Column(name="socket2", type="boolean", nullable=true)
     */
    private $socket2;

    /**
     * @var bool
     *
     * @ORM\Column(name="lamp1", type="boolean", nullable=true)
     */
    private $lamp1;

    /**
     * @var bool
     *
     * @ORM\Column(name="lamp2", type="boolean", nullable=true)
     */
    private $lamp2;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set temperature
     *
     * @param integer $temperature
     *
     * @return Sensors
     */
    public function setTemperature($temperature)
    {
        $this->temperature = $temperature;

        return $this;
    }

    /**
     * Get temperature
     *
     * @return int
     */
    public function getTemperature()
    {
        return $this->temperature;
    }

    /**
     * Set humidity
     *
     * @param integer $humidity
     *
     * @return Sensors
     */
    public function setHumidity($humidity)
    {
        $this->humidity = $humidity;

        return $this;
    }

    /**
     * Get humidity
     *
     * @return int
     */
    public function getHumidity()
    {
        return $this->humidity;
    }

    /**
     * Set photoresistor
     *
     * @param integer $photoresistor
     *
     * @return Sensors
     */
    public function setPhotoresistor($photoresistor)
    {
        $this->photoresistor = $photoresistor;

        return $this;
    }

    /**
     * Get photoresistor
     *
     * @return int
     */
    public function getPhotoresistor()
    {
        return $this->photoresistor;
    }

    /**
     * Set motion
     *
     * @param boolean $motion
     *
     * @return Sensors
     */
    public function setMotion($motion)
    {
        $this->motion = $motion;

        return $this;
    }

    /**
     * Get motion
     *
     * @return bool
     */
    public function getMotion()
    {
        return $this->motion;
    }

    /**
     * Set gas
     *
     * @param integer $gas
     *
     * @return Sensors
     */
    public function setGas($gas)
    {
        $this->gas = $gas;

        return $this;
    }

    /**
     * Get gas
     *
     * @return int
     */
    public function getGas()
    {
        return $this->gas;
    }

    /**
     * Set socket1
     *
     * @param boolean $socket1
     *
     * @return Sensors
     */
    public function setSocket1($socket1)
    {
        $this->socket1 = $socket1;

        return $this;
    }

    /**
     * Get socket1
     *
     * @return bool
     */
    public function getSocket1()
    {
        return $this->socket1;
    }

    /**
     * Set socket2
     *
     * @param boolean $socket2
     *
     * @return Sensors
     */
    public function setSocket2($socket2)
    {
        $this->socket2 = $socket2;

        return $this;
    }

    /**
     * Get socket2
     *
     * @return bool
     */
    public function getSocket2()
    {
        return $this->socket2;
    }

    /**
     * Set lamp1
     *
     * @param boolean $lamp1
     *
     * @return Sensors
     */
    public function setLamp1($lamp1)
    {
        $this->lamp1 = $lamp1;

        return $this;
    }

    /**
     * Get lamp1
     *
     * @return bool
     */
    public function getLamp1()
    {
        return $this->lamp1;
    }

    /**
     * Set lamp2
     *
     * @param boolean $lamp2
     *
     * @return Sensors
     */
    public function setLamp2($lamp2)
    {
        $this->lamp2 = $lamp2;

        return $this;
    }

    /**
     * Get lamp2
     *
     * @return bool
     */
    public function getLamp2()
    {
        return $this->lamp2;
    }
}


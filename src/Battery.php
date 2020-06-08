<?php
namespace src\Battery;

/*
Battery class provides machanism for charning robot with chargeBattery.
Assuming 60 seconds required to get battery fully charged.
*/
class Battery
{
    private $chargeLevel;
    const TIME_TO_FULLCHARGE = 60;

    public function __construct(float $initialLevel)
    {
        $this->chargeLevel = $initialLevel;
    }

    public function getChargeLevel()
    {
        return $this -> chargeLevel;
    }
    
    public function setChargeLevel($chargeLevel)
    {
        $this -> chargeLevel = $chargeLevel;
    }

    public function chargeBattery()
    {
        $timer = 0;
        $this->chargeLevel = 0;
        while ($timer<60) {
            $this->chargeLevel = $this->chargeLevel + (100/Battery::TIME_TO_FULLCHARGE);
            $timer = $timer + 1;
            echo "Charging robot : ".round($this->chargeLevel, 2)."\n";
        }
        echo "Resuming to cleaning...\n";
        return $this->chargeLevel;
    }
}

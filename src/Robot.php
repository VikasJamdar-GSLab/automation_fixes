<?php
namespace src\Robot;

require_once('HardFloor.php');
require_once('CarpetFloor.php');
require_once('Validator.php');
require_once('Battery.php');
use src\Floor\Floor;
use src\HardFloor\HardFloor;
use src\CarpetFloor\CarpetFloor;
use src\Battery\Battery;
use src\Validator as Validator;

/*
Robot class will perform cleaning operation by using Floor and Battery class.
*/
class Robot
{
    public function __construct(float $initialLevel)
    {
        // using composition
        $this->battery = new Battery($initialLevel);
    }

    public function cleanFloor(Floor $floor)
    {
        $timeRequiredToCleanUnitArea =get_class($floor)::TIME_TO_CLEAN_UNIT_AREA;
        // Formula to find charge consumed to clean 1 m**2 area
        $chargeConsumptionForOneUnit = (100*$timeRequiredToCleanUnitArea/Battery::TIME_TO_FULLCHARGE);
        echo "Initial State : chargingLevel : {$this->battery->getChargeLevel()}   Total Area:{$floor->getTotalArea()} Area cleaned : {$floor->getCleanedArea()} m sq\n";
        while ($floor->getCleanedArea()<$floor->getTotalArea()) {
            $chargeLevel = $this->battery->getChargeLevel();
            if ($chargeLevel > 0 && ($chargeLevel - $chargeConsumptionForOneUnit)>0) {
                $this->battery->setChargeLevel($chargeLevel - $chargeConsumptionForOneUnit);
                $cleanedArea = $floor->cleanApartment();
                $rounded_charge = round($this->battery->getChargeLevel(), 2);
                echo "chargingLevel : {$rounded_charge}   Area cleaned : {$cleanedArea} m sq\n";
            } else {
                echo "Robot need power. Switching to charging mode...\n";
                $this->battery->chargeBattery();
            }
        }
        return $floor->getCleanedArea();
    }


    public static function startRobot(array $options)
    {
        try {
            Validator\validate_options($options);
            if ($options) {
                $action = $options['action'];
                $floor = $options['floor'];
                $area = $options['area'];
                
                if (strtoupper($floor) == "HARD") {
                    $floor_obj = new HardFloor($area);
                } elseif (strtoupper($floor) == "CARPET") {
                    $floor_obj = new CarpetFloor($area);
                }
                // Assuming Robot is initially fully charged
                $robot = new Robot(100);
                $robot->cleanFloor($floor_obj);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}

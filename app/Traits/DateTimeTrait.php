<?php

namespace App\Traits;
use Illuminate\Http\Request;  


trait DateTimeTrait{
    protected function timeDiff($firstTime,$lastTime){
        // convert to unix timestamps
        $firstTime=strtotime($firstTime);
        $lastTime=strtotime($lastTime);
        
        // perform subtraction to get the difference (in seconds) between times
        $timeDiff=$lastTime-$firstTime;
        
        // return the difference
        return $timeDiff;
    }

    protected function getMinute($time){
        return $time / 60;
    }

    protected function getHour($time){
        return $time / 3600;
    }

    protected function getDay($time){
        return $time / 86400;
    }

    public function getSendTime($sendTime, $dateNow){
        $difference = $this->timeDiff($this->created_at,date("Y-m-d H:i:s"));
        
        if($this->getMinute($difference) < 1){
            return 'recent';
        }else if($this->getMinute($difference) >= 1 && $this->getMinute($difference) < 60){
            return floor($this->getMinute($difference)) . ' min ago';
        }else if($this->getHour($difference) >= 1 && $this->getHour($difference) < 24){
            return floor($this->getHour($difference)) . ' hour ago';
        }else if($this->getDay($difference) >= 1 && $this->getDay($difference) < 8){
            return floor($this->getDay($difference)) . ' day ago';
        }
        else{
            return date('Y-m-d', strtotime($sendTime));
        }

    }
}
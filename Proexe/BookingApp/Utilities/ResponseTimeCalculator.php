<?php
/**
 * Date: 09/08/2018
 * Time: 00:16
 * @author Artur Bartczak <artur.bartczak@code4.pl>
 */

namespace Proexe\BookingApp\Utilities;

use DateTime;
use Proexe\BookingApp\Offices\Interfaces\ResponseTimeCalculatorInterface;

class ResponseTimeCalculator implements ResponseTimeCalculatorInterface {

    public function calculate($bookingDateTime, $responseDateTime, $officeHours)
    {
        $this->setVariables($bookingDateTime, $responseDateTime, $officeHours);

        $time=[];
        foreach ($this->officeHours as $key=>$value){
            if($key == $this->bookingDayOfTheWeek && $key == $this->responseDayOfTheWeek){
                array_push($time,[$key,$this->sameDayBookedAndResponse()]);
                break;
            }
            if ($key == $this->bookingDayOfTheWeek){
                array_push($time,[$key,$this->timeToEndOfTheDay()]);
                --$this->noDays;
                continue;
            }else if($key == $this->responseDayOfTheWeek){
                array_push($time,[$key,$this->timeFromStartOfTheDay()]);
                --$this->noDays;
                continue;
            }else if ($this->noDays<0){
                break;
            }else{
                array_push($time,[$key,$this->timeOpenedAllDay($key)]);
                --$this->noDays;
            }
        }

        return $time;
    }

    private function setVariables($bookingDateTime, $responseDateTime, $officeHours){
        $this->bookingDateTime=new DateTime($bookingDateTime);
        $this->responseDateTime=new DateTime($responseDateTime);
        $this->officeHours=$officeHours;
        $this->bookingDayOfTheWeek=$this->bookingDateTime->format('l');
        $this->responseDayOfTheWeek=$this->responseDateTime->format('l');
        $this->noDays=$this->numberOfDays();
    }
    private function numberOfDays(){
        $start=new DateTime($this->bookingDateTime->format('Y-m-d'));
        $end=new DateTime($this->responseDateTime->format('Y-m-d'));
        return $start->diff($end)->format('%R%a');
    }

    private function timeOpenedAllDay($day){
        $openTime=$this->officeHours[$day];
        return $this->countMinutesBetweenTwoHours($openTime[0],$openTime[1]);
    }

    private function sameDayBookedAndResponse(){
        $responseTime=$this->responseDateTime->format('H:i');
        $bookingTime=$this->bookingDateTime->format('H:i');
        return $this->countMinutesBetweenTwoHours($responseTime,$bookingTime);

    }
    private function timeToEndOfTheDay(){
        $closeTime=$this->officeHours[$this->bookingDayOfTheWeek][1];
        $bookingTime=$this->bookingDateTime->format('H:i');
        return $this->countMinutesBetweenTwoHours($closeTime,$bookingTime);
    }

    private function timeFromStartOfTheDay(){
        $openTime=$this->officeHours[$this->responseDayOfTheWeek][0];
        $responseTime=$this->responseDateTime->format('H:i');
        return $this->countMinutesBetweenTwoHours($responseTime,$openTime);
    }

    private function countMinutesBetweenTwoHours($hourLatter,$hourBefore){
        $minutesEnd=$this->hoursToMinutes($hourLatter);
        $minutesStart=$this->hoursToMinutes($hourBefore);
        $result=$minutesEnd - $minutesStart;
        return ($result>0)?$result:0;
    }

    private function hoursToMinutes($time){
        $numbers=explode(':',$time);
        if (count($numbers)<2){
            return 0;
        }else{
            return (int)$numbers[0]*60+(int)$numbers[1];
        }
    }

}

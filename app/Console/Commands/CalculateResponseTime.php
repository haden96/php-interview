<?php

namespace App\Console\Commands;

use DateTime;
use Illuminate\Console\Command;
use Proexe\BookingApp\Bookings\Models\BookingModel;
use Proexe\BookingApp\Utilities\ResponseTimeCalculator;

class CalculateResponseTime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookingApp:calculateResponseTime';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculates response time';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $bookings = BookingModel::with('office')->get()->toArray();
        $responseTimeCalculator = new ResponseTimeCalculator();

        $format = "Y-m-d H:i:s";
        foreach ($bookings  as $booking ) {

            $createAt = DateTime::createFromFormat($format, $booking['created_at'])->format('D');
            $updatedAt = DateTime::createFromFormat($format, $booking['updated_at'])->format('D');

            $this->line( "created_at = {$booking['created_at']} ({$createAt})");
            $this->line( "updated_at = {$booking['updated_at']} ({$updatedAt})");
            $this->line( "Opening hours:");
            $hours = $this->hours($booking['office']['office_hours']);
            foreach ($hours as $key=>$item){
                if ($item[0]&&$item[1]=='0:00'){
                    $this->line("{$key} : closed ");
                }else{
                $this->line("{$key} : {$item[0]} - {$item[1]} ");
                }
            };
            $answer=$this->buildAnswer($responseTimeCalculator->calculate($booking['created_at'], $booking['updated_at'], $hours));
            $this->line($answer);
            $this->line(' ');

        };
    }
    private function buildAnswer($items){
        $response="Response time will be:";
        $sum=0;
        $length = count($items);
        foreach ($items as $item){
            if ($item[1]>0){
                $response.=" ".$item[1]." min on ".$item[0];
                $sum += $item[1];
            }else{
                continue;
            };
        };
        $response.=" = ".$sum." minutes";
        return $response;
    }
    private function hours($data)
        {
            $hours = [];
            foreach ($data as $key => $item) {
                if($item['isClosed'] === true) {
                    $hours[$this->getWeekName($key)] = [
                        '0:00',
                        '0:00'
                    ];
                } else {
                    $hours[$this->getWeekName($key)] = [
                        $item['from'],
                        $item['to']
                    ];
                }
            }
            return $hours;

        }
    private function getWeekName($key)
    {
        switch($key) {
            case 0:
                return 'Sunday';
                break;
            case 1:
                return 'Monday';
                break;
            case 2:
                return 'Tuesday';
                break;
            case 3:
                return 'Wednesday';
                break;
            case 4:
                return 'Thursday';
                break;
            case 5:
                return 'Friday';
                break;
            case 6:
                return 'Saturday';
                break;
            default:
                throw new \Exception('Name of week not found');
        }

    }
}

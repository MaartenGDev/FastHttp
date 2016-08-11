<?php


namespace App\Http\Controllers;

use App\Flight;
use App\Repositories\FlightRepository;
use Symfony\Component\HttpFoundation\Response;

class WelcomeController
{
    /**
     * @var FlightRepository
     */
    private $flights;

    public function __construct(FlightRepository $flights)
    {
        $this->flights = $flights;
    }

    public function show($name){
        return view('flights/list',array(
            'flights' => $this->flights->getFlightByName($name)
        ));
    }

    public function flight($name,$description){
        $flight = new Flight();
        $flight->name = $name;
        $flight->description = $description;

        $flight->save();

        return new Response('Created new flight with the name: ' . $name . ' and the following description: '. $description);
    }
}
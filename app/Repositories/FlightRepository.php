<?php


namespace App\Repositories;


use App\Flight;

class FlightRepository
{
    public function getFlightByName($name){
        return Flight::where('name', '=', $name)->get()->all();
    }
}
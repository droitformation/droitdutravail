<?php namespace App\Droit\Service;

class ColloqueWorker{

    protected $custom;
    protected $client;

    /* Inject dependencies */
    public function __construct()
    {
        $this->custom  = new \App\Droit\Helper\Helper();
        $this->client  = new \GuzzleHttp\Client();

        $environment    = \App::environment();
        $this->base_url = ($environment == 'local' ? 'http://lux.local' : 'http://www.publications-droit.ch/fileadmin/lux');
    }

    public function getColloques(){

        $response   = $this->client->get( $this->base_url.'/event', ['query' => ['centres' => ['cemaj','cert'] ]]);
        $data       = json_decode($response->getBody(), true);
        $data       = $this->organise($data['data']);

        $collection = new \Illuminate\Support\Collection($data);

        return $collection;
    }

    public function getArchives(){

        $response   = $this->client->get( $this->base_url.'/event', ['query' => ['archive' => 'archive', 'centres' => ['cemaj','cert'] ]]);
        $data       = json_decode($response->getBody(), true);
        $data       = $this->organiseYear($data['data']);
        $collection = new \Illuminate\Support\Collection($data);

        return $collection;
    }

    public function organise($data){

        if(!empty($data))
        {
            foreach($data as $colloque)
            {
                $centre = (count($colloque['organisateur']) > 1 ? 'both' : $colloque['organisateur'][0]);
                $organise[$centre][] = $colloque;
            }

            $sorting  = array('cert','cemaj');
            $organise = $this->custom->sortArrayByArray($organise,$sorting);

            return $organise;
        }

        return [];
    }

    public function organiseYear($data){

        if(!empty($data))
        {
            foreach($data as $colloque)
            {
                $date = $colloque['event']['dateDebut'];
                $year = \Carbon\Carbon::createFromFormat('Y-m-d', $date);
                $years[$year->year][] = $colloque;
            }

            ksort($years);

            foreach($years as $year => $event)
            {
                $organise[$year] = $this->organise($event);
            }

            krsort($organise);

            return $organise;
        }

        return [];
    }
}
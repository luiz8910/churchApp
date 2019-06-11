<?php

namespace App\Exports;

use App\Services\EventServices;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SubExports implements FromQuery, WithHeadings
{
    use Exportable;

    private $event;

    public function __construct($event)
    {
        $this->event = $event;
    }

    public function headings(): array
    {
        return [
            'Dia', 'Quantidade de Inscritos'
        ];
    }

    public function query()
    {
        EventServices::getListSubEvent($this->event);
    }
}

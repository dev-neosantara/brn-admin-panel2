<?php

namespace Brn\Controllers;


use \Hermawan\DataTables\DataTable;


class EventsController extends \App\Controllers\BaseAdmin
{
    public function index()
    {
        echo view('Brn\Views\events\list');
    }

    public function form($id = null)
    {
        $data = [];
        $db      = \Config\Database::connect();
        $data['categories'] = [
            'hut' => 'HUT',
            'tour' => 'TOUR',
            'kopdar' => 'KOPDAR',
            'uncategorized' => 'Tanpa Kategori'
        ];
        if($id != null){
            $data['data_id'] = $id;
        }
        echo view('Brn\Views\events\form', $data);
    }

    public function listajax($cat_id = null)
    {
        $db = \Config\Database::connect();

        $builder = $db->table('agendas as ag')->select('ag.title, ag.description, ag.start_date, ag.end_date, ag.address, ag.type, ag.id, areas.area')->join('areas', 'ag.area_id = areas.id', 'left')->orderBy('ag.start_date', 'desc');
        return DataTable::of($builder)
            ->setSearchableColumns(['ag.title', 'ag.description', 'ag.address'])
            ->filter(function ($builder, $request) {
        
                if (property_exists($request, 'type') && $request->type != '' && $request->type != null){
                    $builder->where('ag.type', $request->type);
                }
                    
                if (property_exists($request, 'filters')){
                    switch ($request->filters) {
                        case 'thismonth':
                            $builder->where('MONTH(ag.start_date)', date('m'));
                            $builder->where('YEAR(ag.start_date)', date('Y'));
                            break;
                        case 'today':
                            $builder->where('MONTH(ag.start_date)', date('m'));
                            $builder->where('YEAR(ag.start_date)', date('Y'));
                            $builder->where('DAY(ag.start_date)', date('d'));
                            break;
                        case 'upcoming':
                            $builder->where('ag.start_date > ', date('Y-m-d'));
                            break;
                        default:
                            # code...
                            break;
                    }
                }
        
            })
            ->addNumbering() //it will return data output with numbering on first column
            ->toJson();
    }
}
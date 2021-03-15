<?php

namespace Bageur\Karir\Model;

use Illuminate\Database\Eloquent\Model;

class lamaran extends Model
{
    protected $table   = 'bgr_karir_lamaran';

    public function scopeDatatable($query,$request,$page=12)
    {
         $search       = ["perusahaan","judul","posisi"];
        $searchqry    = '';

        $searchqry = "(";
        foreach ($search as $key => $value) {
            if($key == 0){
                $searchqry .= "lower($value) like '%".strtolower($request->search)."%'";
            }else{
                $searchqry .= "OR lower($value) like '%".strtolower($request->search)."%'";
            }
        } 
        $query->select('bgr_karir_lamaran.*','bgr_karir_perusahaan.foto','bgr_karir_perusahaan.perusahaan','bgr_karir.judul','bgr_karir.posisi');
        $query->join('bgr_karir_perusahaan','bgr_karir_perusahaan.id','bgr_karir_lamaran.perusahaan_id');
        $query->join('bgr_karir','bgr_karir.id','bgr_karir_lamaran.karir_id');
        $searchqry .= ")";
        if(@$request->sort_by){
            if(@$request->sort_by != null){
                $explode = explode('.', $request->sort_by);
                 $query->orderBy($explode[0],$explode[1]);
            }else{
                  $query->orderBy('created_at','desc');
            }

             $query->whereRaw($searchqry);
        }else{
             $query->whereRaw($searchqry);
        }

        if($request->get == 'all'){
            return $query->get();
        }else{
                return $query->paginate($page);
        }

    }
}

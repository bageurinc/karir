<?php

namespace Bageur\Karir\Model;

use Illuminate\Database\Eloquent\Model;

class karir extends Model
{
    protected $table   = 'bgr_karir';
    protected $appends = ['avatar'];
    
    public function getAvatarAttribute() {
        return \Bageur::g_gambar($this->foto,'perusahaan',false,'solo');
    }
    public function scopeDatatable($query,$request,$page=12)
    {
        $search       = ["judul",'posisi','perusahaan'];
        $searchqry    = '';

        $searchqry = "(";
        foreach ($search as $key => $value) {
            if($key == 0){
                $searchqry .= "lower($value) like '%".strtolower($request->search)."%'";
            }else{
                $searchqry .= "OR lower($value) like '%".strtolower($request->search)."%'";
            }
        } 
        $query->select('bgr_karir.*','bgr_karir_perusahaan.foto','bgr_karir_perusahaan.perusahaan','bgr_indonesia_kabupaten.nama as kota');
        $query->join('bgr_karir_perusahaan','bgr_karir_perusahaan.id','bgr_karir.perusahaan_id');
        $query->join('bgr_indonesia_provinsi','bgr_indonesia_provinsi.id','bgr_karir_perusahaan.provinsi');
        $query->join('bgr_indonesia_kabupaten','bgr_indonesia_kabupaten.id','bgr_karir_perusahaan.kota');

        if($request->tag){
            $explode = explode(',',$request->tag);
            $query->where(function ($qq) use ($explode) {
                foreach ($explode as $key => $value) {
                    if($key == 0){
                        $qq->where(function ($q) use($value) {
                            $q->whereJsonContains('tags', $value);
                        });
                    }else{
                        $qq->orWhere(function ($q) use($value) {
                            $q->whereJsonContains('tags', $value);
                        });
                    }
                }
            });
        }
        $searchqry .= ")";

        if($request->kota){
             $query->where('bgr_indonesia_kabupaten.id',$request->kota);
        }

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

    public function perusahaan()
    {
         return $this->hasOne('Bageur\Karir\Model\perusahaan','id','perusahaan_id');
    }  
    
}

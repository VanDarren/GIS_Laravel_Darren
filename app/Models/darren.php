<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Darren extends Model
{

    public function tampil($table)
    {
        $this->setTable($table);
        return DB::table($this->table)->get();
    }

    public function tambah($table, $data)
    {
        $this->setTable($table); 
        return DB::table($this->table)->insert($data); 
    }

    public function getWhere($table, $where)
{
    return DB::table($table)->where($where)->first();
}

public function edit($table, $where, $data)
{
    $this->setTable($table);
    return DB::table($this->table)->where($where)->update($data);
}

public function hapus($table, $where)
{
    $this->setTable($table);
    return DB::table($this->table)->where($where)->delete();
}


  
    public function tampil2($tabel)
    {
        return DB::table($tabel)
                 ->whereNull('deleted_at') 
                 ->get();
    }


    public function getTotalAlumni()
    {
        return DB::table('alumni')->count();
    }


    public function getAlumniCountByJurusan()
    {
        return DB::table('alumni')
                 ->select('jurusan', DB::raw('COUNT(*) as count'))
                 ->groupBy('jurusan')
                 ->get();
    }

 
    public function getAlumniList($limit = 5)
    {
        return DB::table('alumni')
                 ->orderBy('id_alumni', 'DESC')
                 ->limit($limit)
                 ->get();
    }

    public function getLogData()
    {
        return DB::table('log')
                 ->select('log.*', 'user.username')
                 ->join('user', 'log.id_user', '=', 'user.id_user')
                 ->orderBy('time', 'DESC')
                 ->get();
    }

    public function logActivity($data)
    {
        return DB::table('log')->insert($data);
    }

  
    public function getBackupData()
    {
        return DB::table('user_backup')->get();
    }

  
    public function getProductById($id)
    {
        return DB::table('user')->where('id_user', $id)->first();
    }
}


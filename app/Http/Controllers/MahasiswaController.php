<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MahasiswaController extends Controller
{
    public function all()
    {
        $mahasiswas = DB::select('SELECT * FROM mahasiswas');
        foreach ($mahasiswas as $mahasiswa) {
            echo "$mahasiswa->nim | $mahasiswa->nama | $mahasiswa->jurusan <br>";
        }
    }

    public function gabung1()
    {
        $mahasiswas = DB::select('SELECT * FROM mahasiswas, nilais WHERE
 mahasiswas.id = nilais.mahasiswa_id');
        dump($mahasiswas);
    }

    public function gabung2()
    {

        $mahasiswas = DB::select('SELECT * FROM mahasiswas, nilais WHERE
 mahasiswas.id = nilais.mahasiswa_id');

        foreach ($mahasiswas as $mahasiswa) {
            echo "$mahasiswa->nim | $mahasiswa->nama | $mahasiswa->jurusan | ";
            echo "$mahasiswa->sem_1 | $mahasiswa->sem_2 | $mahasiswa->sem_3 <br> ";
        }
    }

    public function gabungJoin1()
    {
        $mahasiswas = DB::select('SELECT * FROM mahasiswas JOIN nilais ON
 nilais.mahasiswa_id = mahasiswas.id');
        foreach ($mahasiswas as $mahasiswa) {
            echo "$mahasiswa->nim | $mahasiswa->nama | $mahasiswa->jurusan | ";
            echo "$mahasiswa->sem_1 | $mahasiswa->sem_2 | $mahasiswa->sem_3 <br> ";
        }
    }

    public function gabungJoin2()
    {
        $mahasiswas = DB::select('SELECT * FROM mahasiswas JOIN nilais ON
 mahasiswas.id = nilais.mahasiswa_id WHERE jurusan = "Ilmu Komputer"');
        foreach ($mahasiswas as $mahasiswa) {
            echo "$mahasiswa->nim | $mahasiswa->nama | $mahasiswa->jurusan | ";
            echo "$mahasiswa->sem_1 | $mahasiswa->sem_2 | $mahasiswa->sem_3 <br> ";
        }
    }

    public function gabungJoin3()
    {
        $mahasiswas = DB::select('SELECT * FROM mahasiswas JOIN nilais ON
 mahasiswas.id = nilais.mahasiswa_id WHERE nilais.sem_2 > 3');

        foreach ($mahasiswas as $mahasiswa) {
            echo "$mahasiswa->nim | $mahasiswa->nama | $mahasiswa->jurusan | ";
            echo "$mahasiswa->sem_1 | $mahasiswa->sem_2 | $mahasiswa->sem_3 <hr> ";
        }
    }

    public function find()
    {
        // $mahasiswa = Mahasiswa::find(1);
        // dump($mahasiswa->nilai);

        $mahasiswa = Mahasiswa::find(8);
        dump($mahasiswa->toArray());
        dump($mahasiswa->nilai->toArray());

        echo $mahasiswa->nim . "<br>";
        echo $mahasiswa->nama . "<br>";
        echo $mahasiswa->jurusan . "<br>";
        echo $mahasiswa->nilai->sem_1 . "<br>";
        echo $mahasiswa->nilai->sem_2 . "<br>";
        echo $mahasiswa->nilai->sem_3 . "<br>";
    }


    public function where()
    {
        $mahasiswa = Mahasiswa::where('nama', 'Mustofa Simanjuntak')->first();

        echo "$mahasiswa->nim | $mahasiswa->nama | $mahasiswa->jurusan | ";
        echo "{$mahasiswa->nilai->sem_1}, | {$mahasiswa->nilai->sem_2} | ";

        echo "{$mahasiswa->nilai->sem_3}";
    }

    public function whereChaining()
    {
        $nilai = Mahasiswa::where('nama', 'Mustofa Simanjuntak')->first()->nilai->sem_2;
        echo $nilai; // 2.98
    }

    public function allJoin()
    {
        $mahasiswas = Mahasiswa::with('nilai')->get();

        // foreach ($mahasiswas as $mahasiswa) {
        //     echo "$mahasiswa->nim | $mahasiswa->nama | $mahasiswa->jurusan | ";
        //     echo "{$mahasiswa->nilai->sem_1} | {$mahasiswa->nilai->sem_2} | ";
        //     echo "{$mahasiswa->nilai->sem_3} <hr>";
        // }

        foreach ($mahasiswas as $mahasiswa) {
            echo "$mahasiswa->nim | $mahasiswa->nama | $mahasiswa->jurusan | ";
            echo $mahasiswa->nilai->sem_1 ?? 'N/A';
            echo " | ";
            echo $mahasiswa->nilai->sem_2 ?? 'N/A';
            echo " | ";
            echo $mahasiswa->nilai->sem_3 ?? 'N/A';
            echo " | ";
            echo "<br>";
        }
    }

    public function has()
    {
        // $mahasiswas = Mahasiswa::has('nilai')->get();
        $mahasiswas = Mahasiswa::with('nilai')->has('nilai')->get();
        foreach ($mahasiswas as $mahasiswa) {
            echo "$mahasiswa->nim | $mahasiswa->nama | $mahasiswa->jurusan | ";
            echo "{$mahasiswa->nilai->sem_1} | {$mahasiswa->nilai->sem_2} | ";
            echo "{$mahasiswa->nilai->sem_3} <br>";
        }
    }

    public function whereHas()
    {
        // $mahasiswas = Mahasiswa::whereHas('nilai', function ($query) {
        //     $query->where('sem_1', '>=', 3);
        // })->get();

        $mahasiswas = Mahasiswa::with('nilai')->whereHas('nilai', function ($query) {
            $query->where('sem_1', '>=', 3);
        })->get();

        foreach ($mahasiswas as $mahasiswa) {
            echo "$mahasiswa->nim | $mahasiswa->nama | $mahasiswa->jurusan | ";
            echo "{$mahasiswa->nilai->sem_1} | {$mahasiswa->nilai->sem_2} | ";
            echo "{$mahasiswa->nilai->sem_3} <br>";
        }
    }

    public function doesntHave()
    {
        $mahasiswas = Mahasiswa::doesntHave('nilai')->get();

        foreach ($mahasiswas as $mahasiswa) {
            echo "$mahasiswa->nim | $mahasiswa->nama | $mahasiswa->jurusan <br>";
        }
    }

    public function whereDoesntHave()
    {
        $mahasiswas = Mahasiswa::whereDoesntHave('nilai', function ($query) {
            $query->where('sem_1', '>=', 3);
        })->get();

        foreach ($mahasiswas as $mahasiswa) {
            echo "$mahasiswa->nim | $mahasiswa->nama | $mahasiswa->jurusan <br>";
        }
    }

    public function insertSave()
    {
        $mahasiswa = new Mahasiswa;
        $mahasiswa->nim = '19005011';
        $mahasiswa->nama = 'Riana Putria';
        $mahasiswa->jurusan = 'Ilmu Komputer';
        $mahasiswa->save();

        $nilai = new \App\Models\Nilai;
        $nilai->sem_1 = 3.12;
        $nilai->sem_2 = 3.23;
        $nilai->sem_3 = 3.34;

        $mahasiswa->nilai()->save($nilai);
        echo "Penambahan $mahasiswa->nama ke database berhasil";
    }

    public function insertCreate()
    {
        $mahasiswa = Mahasiswa::create(
            [
                'nim' => '19021044',
                'nama' => 'Rudi Permana',
                'jurusan' => 'Teknik Informatika',
            ]
        );

        $mahasiswa->nilai()->create([
            'sem_1' => 2.19,
            'sem_2' => 2.68,
            'sem_3' => 3.07,
        ]);

        echo "Penambahan $mahasiswa->nama ke database berhasil";
    }


    public function updatePush()
    {
        $mahasiswa = Mahasiswa::find(9);

        $mahasiswa->nilai->sem_1 = 2.44;
        $mahasiswa->nilai->sem_2 = 2.55;
        $mahasiswa->nilai->sem_3 = 2.66;

        $mahasiswa->push();
        echo "Update nilai $mahasiswa->nama berhasil";
    }

    public function updatePushWhere()
    {
        $mahasiswa = Mahasiswa::where('nama', 'Hesti Ramadan')->first();
        $mahasiswa->nilai->sem_1 = 2.44;
        $mahasiswa->nilai->sem_2 = 2.55;
        $mahasiswa->nilai->sem_3 = 2.66;

        $mahasiswa->push();
        echo "Data $mahasiswa->nama berhasil di update";
    }

    public function deleteFind()
    {
        $mahasiswa = Mahasiswa::find(1);
        $mahasiswa->nilai->delete();
        $mahasiswa->delete();

        echo "Data $mahasiswa->nama berhasil di hapus";
    }

    public function deleteWhere()
    {
        $mahasiswa = Mahasiswa::where('nama', 'Ika Puspasari')->firstOrFail();
        $mahasiswa->nilai->delete();
        $mahasiswa->delete();

        echo "Data $mahasiswa->nama berhasil di hapus";
    }

    public function deleteIf()
    {
        $mahasiswa = Mahasiswa::where('nama', 'Yuliana Nurdiyanti')->firstOrFail();
        if (!empty($mahasiswa->nilai)) {
            $mahasiswa->nilai->delete();
        }
        $mahasiswa->delete();

        echo "Data $mahasiswa->nama berhasil di hapus";
    }

    public function deleteCascade()
 {

 $mahasiswa = Mahasiswa::where('nama','Hesti Ramadan')->firstOrFail();
 $mahasiswa->delete();
 echo "Data $mahasiswa->nama berhasil di hapus <br>";

 $mahasiswa = Mahasiswa::where('nama','Yuliana Nurdiyanti')->firstOrFail();
 $mahasiswa->delete();
 echo "Data $mahasiswa->nama berhasil di hapus";
 }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Forms extends Model
{
    use HasFactory;

    protected $table = 'forms';

    // Jika menggunakan UUID sebagai id
    // public $incrementing = false;
    // protected $keyType = 'string';

    protected $fillable = [
        'id',
        'user_id',
        'tgl_mulai',
        'tgl_akhir',
        'nama',
        'ponsel',
        'email',
        'asal_sekolah',
        'jurusan',
        'surat',
        'status'
    ];

    // Jika nama, ponsel, dan email disimpan sebagai array JSON
    protected $casts = [
        'nama' => 'array',
        'ponsel' => 'array',
        'email' => 'array',
    ];

    // Menonaktifkan timestamps jika tidak digunakan
    // public $timestamps = false;

    public function user(){
        return $this->belongsTo(User::class);
    }
}

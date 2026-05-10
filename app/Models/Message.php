<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    // Veritabanındaki bu sütunlara toplu veri girişine izin veriyoruz
    protected $fillable = ['name', 'email', 'message'];
}
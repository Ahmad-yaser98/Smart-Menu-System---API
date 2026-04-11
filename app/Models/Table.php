<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    protected $fillable = ['table_number', 'capacity', 'status', 'waiter_id'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function waiter()
    {
        return $this->belongsTo(User::class, 'waiter_id');
    }
}
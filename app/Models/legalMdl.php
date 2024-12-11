<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class legalMdl extends Model
{
    use HasFactory;

    protected $table = "tbl_admin_legal_docs";

    protected $fillable = ['documentName','legalType','legalEntity','issueDate','expirationDate','department','status',"legalName"];

    public $timestamps = false;
}

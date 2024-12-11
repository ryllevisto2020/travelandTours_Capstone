<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class legalApprovalMdl extends Model
{
    use HasFactory;

    protected $table = "tbl_admin_legal_approval";

    protected $fillable = ["documentName","legalType","legalEntity","issueDate","expirationDate","department","status"];

    public $timestamps = false;
}

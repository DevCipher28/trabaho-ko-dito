<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_posting_id',
        'job_seeker_id',
        'cover_letter',
        'resume_path',
        'status',
    ];

    // Relationships
    public function jobPosting()
    {
        return $this->belongsTo(JobPosting::class);
    }

    public function jobSeeker()
    {
        return $this->belongsTo(User::class, 'job_seeker_id');
    }
}
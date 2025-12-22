<?php

namespace Database\Seeders;

use App\Models\VoteCount;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VoteCountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $votecounts = [
            [
                'candidate_id' => 1,
                'vote_count' => 11,
            ],
            [
                'candidate_id' => 2,
                'vote_count' => 123,
            ],
            [
                'candidate_id' => 3,
                'vote_count' => 911,
            ],
            [
                'candidate_id' => 4,
                'vote_count' => 456,
            ],
            [
                'candidate_id' => 5,
                'vote_count' => 789,
            ],
            [
                'candidate_id' => 6,
                'vote_count' => 234,
            ],
            [
                'candidate_id' => 7,
                'vote_count' => 567,
            ],
            [
                'candidate_id' => 8,
                'vote_count' => 890,
            ],
            [
                'candidate_id' => 9,
                'vote_count' => 345,
            ],
            [
                'candidate_id' => 10,
                'vote_count' => 678,
            ],
            [
                'candidate_id' => 11,
                'vote_count' => 192,
            ],
            [
                'candidate_id' => 12,
                'vote_count' => 523,
            ],
            [
                'candidate_id' => 13,
                'vote_count' => 741,
            ],
            [
                'candidate_id' => 14,
                'vote_count' => 298,
            ],
            [
                'candidate_id' => 15,
                'vote_count' => 856,
            ]
        ];
        
        DB::table('vote_counts')->insert($votecounts);
    }
}
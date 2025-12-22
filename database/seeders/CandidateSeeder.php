<?php
namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CandidateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $candidates = [
            [
                'candidate_name' => 'Janna Rafaela Villacorta',
                'party_affiliation' => 'Makibaka Partylist',
                'position_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'candidate_name' => 'Maverick Angela Shibal',
                'party_affiliation' => 'Flood Control Partylist',
                'position_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'candidate_name' => 'Percy Shibala',
                'party_affiliation' => 'Batas Partylist',
                'position_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'candidate_name' => 'Maria Santos',
                'party_affiliation' => 'Progresibo Partylist',
                'position_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'candidate_name' => 'Juan dela Cruz',
                'party_affiliation' => 'Kabataan Partylist',
                'position_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'candidate_name' => 'Ana Reyes',
                'party_affiliation' => 'Kaunlaran Partylist',
                'position_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'candidate_name' => 'Roberto Garcia',
                'party_affiliation' => 'Bayan Muna',
                'position_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'candidate_name' => 'Sofia Mendoza',
                'party_affiliation' => 'Akbayan Partylist',
                'position_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'candidate_name' => 'Carlos Ramos',
                'party_affiliation' => 'Agri Partylist',
                'position_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'candidate_name' => 'Isabella Torres',
                'party_affiliation' => 'Gabriela Partylist',
                'position_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'candidate_name' => 'Miguel Fernandez',
                'party_affiliation' => 'ACT Teachers',
                'position_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'candidate_name' => 'Lucia Morales',
                'party_affiliation' => 'Senior Citizens Partylist',
                'position_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'candidate_name' => 'Diego Pascual',
                'party_affiliation' => 'OFW Partylist',
                'position_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'candidate_name' => 'Carmen Lopez',
                'party_affiliation' => 'Health Workers Partylist',
                'position_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'candidate_name' => 'Rafael Santiago',
                'party_affiliation' => 'Transport Partylist',
                'position_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        
        DB::table('candidates')->insert($candidates);
    }
}
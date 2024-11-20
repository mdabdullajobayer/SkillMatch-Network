<?php

namespace Database\Seeders;

use App\Models\UserSkill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserSkill::create([
            'name' => 'Web Development',
            'description' => 'Web Developer',
            'user_id' => 2
        ]);
        UserSkill::create([
            'name' => 'Software Development',
            'description' => 'Web Developer',
            'user_id' => 2
        ]);
        UserSkill::create([
            'name' => 'Game Development',
            'description' => 'Web Developer',
            'user_id' => 2
        ]);
        UserSkill::create([
            'name' => 'BlockChain Development',
            'description' => 'Web Developer',
            'user_id' => 2
        ]);
        UserSkill::create([
            'name' => 'AL/ML Development',
            'description' => 'Web Developer',
            'user_id' => 2
        ]);
    }
}

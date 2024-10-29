<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    private const POSITIONS = [
        [
            'name'  => 'Lawyer',
        ],
        [
            'name'  => 'Content manager',
        ],
        [
            'name'  => 'Designer',
        ],
        [
            'name'  => 'Developer',
        ]
    ];

    public function run(): void
    {
        foreach (self::POSITIONS as $position) {
            Position::query()->updateOrCreate(
                [
                    'name' => $position['name'],
                ],
                [
                    'name'  => $position['name'],
                ]
            );
        }
    }
}

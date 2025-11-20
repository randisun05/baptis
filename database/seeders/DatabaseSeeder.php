<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Event;
use App\Models\Member;
use App\Models\Category;
use App\Models\instansi;
use App\Models\ItemProfile;
use App\Models\Management;
use App\Models\Registration;
use App\Models\ProfileDataMain;
use App\Models\ProfileDataPosition;
use App\Models\RefEvent;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Member::create([
            'nik'      => '1234567890123456',
            'name'      => 'John Doe',
            'email'     => 'johndoe@example.com',
            'password'  => bcrypt('password'),
            'status'    => 'confirm',
        ]);

        Member::create([
            'nik'      => '6543210987654321',
            'name'      => 'Jane Smith',
            'email'     => 'janesmith@example.com',
            'password'  => bcrypt('password'),
            'status'    => 'confirm',
        ]);

          Member::create([
            'nik'      => '1122334455667788',
            'name'      => 'Alice Johnson',
            'email'     => 'alicejohnson@example.com',
            'password'  => bcrypt('password'),

        ]);

          User::create([
            'nik'      => '0000000000000000',
            'name'      => 'Administrator',
            'email'     => 'admin@gmail.com',
            'role'     => 'administrator',
            'password'  => bcrypt('password'),
        ]);

        RefEvent::create([
            'title' => 'kegiatan 1',
        ]);

         RefEvent::create([
            'title' => 'kegiatan 2',
        ]);

         RefEvent::create([
            'title' => 'kegiatan 3',
        ]);


        Event::create([
            'title' => 'Baptis Massal Januari',
            'ref_event_id' => 1,
            'date' => '2024-01-20',
            'place' => 'Gereja St. Maria',
        ]);

          Event::create([
            'title' => 'Baptis Massal Februari',
            'ref_event_id' => 2,
            'date' => '2024-02-15',
            'place' => 'Gereja St. Yosef',
        ]);

            Event::create([
                'title' => 'Baptis Massal Maret',
                'ref_event_id' => 3,
                'date' => '2024-03-10',
                'place' => 'Gereja St. Paulus',
            ]);
    }




}

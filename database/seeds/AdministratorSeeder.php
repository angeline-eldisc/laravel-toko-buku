<?php

use Illuminate\Database\Seeder;
use App\User;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $a = new \App\User;
        $a->username = "admin";
        $a->name = "Site Admin";
        $a->email = "admin@admin.com";
        $a->roles = json_encode(["ADMIN", "STAFF"]);
        $a->password = \Hash::make(1234);
        $a->avatar = "admin.png";
        $a->address = "Jl. Kamal Raya, Cengkareng, Jakarta Barat";
        $a->phone = 02173441517;

        $a->save();

        User::create([
            'username' => 'diana',
            'name' => 'Diana Rosevelt',
            'email' => 'diana@example.com',
            'roles' => json_encode(["STAFF"]),
            'password' => bcrypt('1234'),
            'avatar' => NULL,
            'address' => 'Jl. Bunga Murah Meriah No. 30, Jakarta Timur',
            'phone' => '081892384958'
        ]);

        User::create([
            'username' => 'wanya',
            'name' => 'Jawanya Fleoda',
            'email' => 'wanya@example.com',
            'roles' => json_encode(["STAFF"]),
            'password' => bcrypt('1234'),
            'avatar' => NULL,
            'address' => 'Jl. Apel Kuning Merah No. 18, Jakarta Pusat',
            'phone' => '08192839485',
            'status' => 'INACTIVE'
        ]);

        User::create([
            'username' => 'ishid',
            'name' => 'Ishid Winnight',
            'email' => 'ishid@example.com',
            'roles' => json_encode(["CUSTOMER"]),
            'password' => bcrypt('1234'),
            'avatar' => 'user-1.png',
            'address' => 'Jl. Barat Timur Gangang No. 89, Jakarta Utara',
            'phone' => '08129384958'
        ]);

        User::create([
            'username' => 'sania',
            'name' => 'Sania Bloomsberg',
            'email' => 'sania@example.com',
            'roles' => json_encode(["CUSTOMER"]),
            'password' => bcrypt('1234'),
            'avatar' => 'user-2.png',
            'address' => 'Jl. Daun Merah Dini No. 46, Jakarta Pusat',
            'phone' => '081928373485'
        ]);

        User::create([
            'username' => 'Rio',
            'name' => 'Rio Sanjaya',
            'email' => 'rio@example.com',
            'roles' => json_encode(["CUSTOMER"]),
            'password' => bcrypt('1234'),
            'avatar' => 'user-3.png',
            'address' => 'Jl. Lolipanda Merdeka Jaya No. 72, Jakarta Selatan',
            'phone' => '08129304956'
        ]);

        $this->command->info("User Admin berhasil dimasukan!");
    }
}



<?php

use App\Contact;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contacts')->insert([
            "name" => "Jorge",
            "email" => "jorgeallan@msn.com",
            "telephone" => "(71)98506-7620",
            "message" => "Testando aplicativo",
            "ip" => "127.0.0.1",
            "file" => "file/YlnNaAwqonPbUElvlVxoaC78QQoH5YpMy9GioZjR.jpg"
        ]);
    }
}

<?php

namespace Tests\Feature;

use App\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class Contactest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetAll()
    {
        $response = $this->get('/api/contact');
        $response->assertOk();
        $response->assertJsonStructure([
            "*"=>[
                "id",
                "name",
                "email",
                "telephone",
                "message",
                
            ]
        ]);
    }
   


    public function testStore(){
        
        $request = [
            "name" => "Jorge",
            "email" => "jorgeallan@msn.com",
            "telephone" => "(71)98506-7620",
            "message" => "Estou testando um software",
            "file" => new UploadedFile(resource_path('doc/curriculum.pdf'), 'test.pdf', null, null, true),
        ];
        DB::beginTransaction();     
        $response = $this->post('/api/contact',$request);
        $response->assertOk();
        $response->assertJsonStructure([
            "id",
            "name",
            "email",
            "telephone",
            "message",
            "file"
        ]);
        unset($request['file']);
        $response->assertJsonFragment($request);
        DB::rollBack();     
    }

    public function testUpdate(){
        
        $contacts = Contact::limit(100)->get();
        $contact = array_rand($contacts->all(), 1);
        $contact_id = $contacts[$contact]->id;
        $request = [
            "_method" => "PUT",
            "name" => "Jorge Alan",
            "email" => "jorgeallan@msn.com",
            "telephone" => "(71)98506-7620",
            "message" => "Estou testando um aplicativo",
            "file" => new UploadedFile(resource_path('doc/curriculum.pdf'), 'test.pdf', null, null, true),
        ];
        DB::beginTransaction();     
        $response = $this->withHeader('Content-Type','multipart/form-data')->post('/api/contact/'.$contact_id,$request);
        $response->assertOk();
        
        $response->assertJsonStructure([
            "id",
            "name",
            "email",
            "telephone",
            "message",
            "file"
        ]);
        unset($request['file']);
        unset($request['_method']);
        $response->assertJsonFragment($request);
        DB::rollBack();     
    }

    public function testDestroy(){
               
        $contacts = Contact::limit(100)->get();
        $contact = array_rand($contacts->all(), 1);
        $contact_id = $contacts[$contact]->id;
        
        DB::beginTransaction();     
        $response = $this->delete('/api/contact/'.$contact_id);
        $response->assertOk();
        $response->assertJsonStructure([
            "id",
            "name",
            "email",
            "telephone",
            "message",
            "file"
        ]);
        
        DB::rollBack();     
    }

}

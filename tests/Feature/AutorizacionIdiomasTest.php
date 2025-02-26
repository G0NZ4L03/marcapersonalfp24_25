<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Idiomas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Testing\TestResponse;

class AutorizacionIdiomasTest extends TestCase
{
    private static $apiurl_idioma = '/api/v1/familias_profesionales';

    public function Idiomas_Index() : TestResponse
    {
        return $this->get(self::$apiurl_idioma);
    }

    public function Idiomas_Show() : TestResponse
    {
        $Idiomas = Idiomas::inRandomOrder()->first();
        return $this->get(self::$apiurl_idioma . "/{$Idiomas->id}");
    }

    public function Idiomas_Store() : TestResponse
    {
        $data = [
            'user_id' => 1,
            'video_Idiomas' => '123456',
        ];
        return $this->postJson(self::$apiurl_idioma, $data);
    }

    public function Idiomas_Update($propio = false) : TestResponse
    {
        $Idiomas = $propio
        ? Idiomas::create(['user_id' => Auth::user()->id, 'video_curriculum' => '123456'])
            : Idiomas::inRandomOrder()->first();
        $data = [
            'user_id' => 1,
            'video_Idiomas' => '123456',
        ];
        return $this->putJson(self::$apiurl_idioma . "/{$Idiomas->id}", $data);
    }

    public function Idiomas_Delete($propio = false) : TestResponse
    {
        $Idiomas = $propio
            ? Idiomas::create(['user_id' => Auth::user()->id, 'video_curriculum' => '123456'])
            : Idiomas::inRandomOrder()->first();
        return $this->delete(self::$apiurl_idioma . "/{$Idiomas->id}");
    }

    public function test_anonymous_can_access_Familia_Profesional_list_and_view()
    {
        $this->assertGuest();

        $response = $this->Idiomas_Index();
        $response->assertStatus(200);

        $response = $this->Idiomas_Show();
        $response->assertStatus(200);

        $response = $this->Idiomas_Store();
        $response->assertUnauthorized();

        $response = $this->Idiomas_Update();
        $response->assertUnauthorized();

        $response = $this->Idiomas_Delete();
        $response->assertFound();

    }

    public function test_admin_can_CRUD_Idiomas()
    {
        $admin = User::where('email', env('ADMIN_EMAIL'))->first();
        $this->actingAs($admin);

        $response = $this->Idiomas_Index();
        $response->assertSuccessful();

        $response = $this->Idiomas_Show();
        $response->assertSuccessful();

        $response = $this->Idiomas_Store();
        $response->assertSuccessful();

        $response = $this->Idiomas_Update();
        $response->assertSuccessful();

        $response = $this->Idiomas_Delete();
        $response->assertSuccessful();
    }

    public function test_docente_can_access_Idiomas_list_and_view()
    {
        $docente = User::where([
                ['email', 'like', '%@' . env('TEACHER_EMAIL_DOMAIN')],
                ['email', '!=', env('ADMIN_EMAIL')],
            ])->first();
        $this->actingAs($docente);

        $response = $this->Idiomas_Index();
        $response->assertSuccessful();

        $response = $this->Idiomas_Show();
        $response->assertSuccessful();

        $response = $this->Idiomas_Store();
        $response->assertForbidden();

        $response = $this->Idiomas_Update();
        $response->assertForbidden();

        $response = $this->Idiomas_Delete();
        $response->assertForbidden();
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\FamiliaProfesional;
use Illuminate\Support\Facades\Auth;
use Illuminate\Testing\TestResponse;

class AutorizacionFamiliasProfesionalesTest extends TestCase
{
    private static $apiurl_familia_profesional = '/api/v1/familias_profesionales';

    public function FamiliaProfesional_Index() : TestResponse
    {
        return $this->get(self::$apiurl_familia_profesional);
    }

    public function FamiliaProfesional_Show() : TestResponse
    {
        $FamiliaProfesional = FamiliaProfesional::inRandomOrder()->first();
        return $this->get(self::$apiurl_familia_profesional . "/{$FamiliaProfesional->id}");
    }

    public function FamiliaProfesional_Store() : TestResponse
    {
        $data = [
            'user_id' => 1,
            'video_FamiliaProfesional' => '123456',
        ];
        return $this->postJson(self::$apiurl_familia_profesional, $data);
    }

    public function FamiliaProfesional_Update($propio = false) : TestResponse
    {
        $FamiliaProfesional = $propio
        ? FamiliaProfesional::create(['user_id' => Auth::user()->id, 'video_curriculum' => '123456'])
            : FamiliaProfesional::inRandomOrder()->first();
        $data = [
            'user_id' => 1,
            'video_FamiliaProfesional' => '123456',
        ];
        return $this->putJson(self::$apiurl_familia_profesional . "/{$FamiliaProfesional->id}", $data);
    }

    public function FamiliaProfesional_Delete($propio = false) : TestResponse
    {
        $FamiliaProfesional = $propio
            ? FamiliaProfesional::create(['user_id' => Auth::user()->id, 'video_curriculum' => '123456'])
            : FamiliaProfesional::inRandomOrder()->first();
        return $this->delete(self::$apiurl_familia_profesional . "/{$FamiliaProfesional->id}");
    }

    public function test_anonymous_can_access_Familia_Profesional_list_and_view()
    {
        $this->assertGuest();

        $response = $this->FamiliaProfesional_Index();
        $response->assertStatus(200);

        $response = $this->FamiliaProfesional_Show();
        $response->assertStatus(200);

        $response = $this->FamiliaProfesional_Store();
        $response->assertUnauthorized();

        $response = $this->FamiliaProfesional_Update();
        $response->assertUnauthorized();

        $response = $this->FamiliaProfesional_Delete();
        $response->assertFound();

    }

    public function test_admin_can_CRUD_FamiliaProfesional()
    {
        $admin = User::where('email', env('ADMIN_EMAIL'))->first();
        $this->actingAs($admin);

        $response = $this->FamiliaProfesional_Index();
        $response->assertSuccessful();

        $response = $this->FamiliaProfesional_Show();
        $response->assertSuccessful();

        $response = $this->FamiliaProfesional_Store();
        $response->assertSuccessful();

        $response = $this->FamiliaProfesional_Update();
        $response->assertSuccessful();

        $response = $this->FamiliaProfesional_Delete();
        $response->assertSuccessful();
    }

    public function test_docente_can_access_FamiliaProfesional_list_and_view()
    {
        $docente = User::where([
                ['email', 'like', '%@' . env('TEACHER_EMAIL_DOMAIN')],
                ['email', '!=', env('ADMIN_EMAIL')],
            ])->first();
        $this->actingAs($docente);

        $response = $this->FamiliaProfesional_Index();
        $response->assertSuccessful();

        $response = $this->FamiliaProfesional_Show();
        $response->assertSuccessful();

        $response = $this->FamiliaProfesional_Store();
        $response->assertForbidden();

        $response = $this->FamiliaProfesional_Update();
        $response->assertForbidden();

        $response = $this->FamiliaProfesional_Delete();
        $response->assertForbidden();
    }
}

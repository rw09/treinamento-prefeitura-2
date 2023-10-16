<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use DB;
use Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //\App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Admin TI',
            'email' => 'adminTI@email.com',
            'email_verified_at' => now(),
            'password' => '123456',
            'cpf' => '655.195.360-31',
            'remember_token' => null,
            'perfil' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Admin Sistema',
            'email' => 'adminSistema@email.com',
            'email_verified_at' => now(),
            'password' => '123456',
            'cpf' => '894.544.780-60',
            'remember_token' => null,
            'perfil' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Operador',
            'email' => 'operador@email.com',
            'email_verified_at' => now(),
            'password' => '123456',
            'cpf' => '305.480.277-90',
            'remember_token' => null,
            'perfil' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('departamentos')->insert(['nome' => 'TI']);
        DB::table('departamentos')->insert(['nome' => 'Educação']);
        DB::table('departamentos')->insert(['nome' => 'Saúde']);
        DB::table('departamentos')->insert(['nome' => 'Obras']);
        DB::table('departamentos')->insert(['nome' => 'Segurança Pública']);

        DB::table('contribuintes')->insert([
            'nome' => 'João da Silva',
            'data_nascimento' => '1976/05/12',
            'cpf' => '038.214.064-88',
            'sexo' => 'M',
            'rua' => 'Av. Henrique Bier',
            'numero' => '298',
            'bairro' => 'Campina',
            'cidade' => 'São Leopoldo'
        ]);

        DB::table('contribuintes')->insert([
            'nome' => 'Maria de Souza',
            'data_nascimento' => '1989/03/21',
            'cpf' => '317.748.434-12',
            'sexo' => 'F',
            'rua' => 'Av. Marcílio dias',
            'numero' => '145',
            'bairro' => 'Campina',
            'cidade' => 'São Leopoldo'
        ]);

        DB::table('protocolos')->insert([
            'departamento_id' => 2,
            'contribuinte_id' => 1,
            'created_at' => now(),
            'descricao' => 'Solicitação de bolsa de estudos',
            'prazo' => 30,
        ]);

        DB::table('protocolos')->insert([
            'descricao' => 'Solicitação de reparo em buraco na rua',
            'departamento_id' => 4,
            'contribuinte_id' => 2,
            'created_at' => now(),
            
            'prazo' => 20,
        ]);
    }
}

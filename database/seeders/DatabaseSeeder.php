<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Pnf;
use App\Models\Plan;
use App\Models\Nucleo;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(PlanesTableSeeder::class);
        $this->call(PnfsTableSeeder::class);
        $this->call(TrayectosTableSeeder::class);
        $this->call(AsignaturasTableSeeder::class);
        $this->call(DesAsignaturasTableSeeder::class);
        $this->call(DocentesTableSeeder::class);
        $this->call(PeriodosTableSeeder::class);

        $this->call(RolTableSeeder::class);

        $usuario = User::create([
            'cedula' => '11',
            'nombre' => 'Ramón',
            'apellido' => 'Maita',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('maita123486')
        ]);

        $usuario->roles()->sync([1,4]);

    }
}

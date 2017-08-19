<?php

use Illuminate\Database\Seeder;

class ObjectsListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('objects_list')->insert([
            'title' => 'test object',
            'brief_description' => 'shows how to look brief description',
            'description' => 'In computer programming, the term SOLID is a mnemonic acronym for five design principles intended to make software designs more understandable, flexible and maintainable. The principles are a subset of many principles promoted by Robert C. Martin, [1][2][3]. Though they apply to any object-oriented design, the SOLID principles can also form a core philosophy for methodologies such as agile development or Adaptive Software Development.[3] The SOLID acronym was introduced by Michael Feathers.',
            'latitude'    => '50.4501',
            'longitude'   => '30.5234',
            'rating_good' => '0',
            'rating_bad'  => '0',
            'user_id'     => '1',
            'approve'     => '1',
            'id_object_type' => '0'
        ]);
    }
}

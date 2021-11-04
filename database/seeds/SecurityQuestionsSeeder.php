<?php

use Illuminate\Database\Seeder;

use App\SecurityQuestion;

class SecurityQuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $query = new SecurityQuestion;
        $query->query = 'What is first item you sold/post on cush self?';
        $query->description = 'Give short name for your first item';
        $query->save();

        $query = new SecurityQuestion;
        $query->query = 'Where is the your Mom and Dad meet for first time?';
        $query->description = 'Give the name of the location where you family meets';
        $query->save();

        $query = new SecurityQuestion;
        $query->query = 'When will you use social media most of the time?';
        $query->description = 'Provide a time (Morning, Evening) you use social media frequently';
        $query->save();

        $query = new SecurityQuestion;
        $query->query = 'What is the name of your first best friend?';
        $query->description = 'Give the of your first best friend';
        $query->save();

        $query = new SecurityQuestion;
        $query->query = 'How old were you when you got your first smart phone?';
        $query->description = 'When did you get your first smart phone';
        $query->save();
    }
}